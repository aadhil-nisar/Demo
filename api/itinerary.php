<?php
require_once __DIR__ . '/../config/app.php';
header('Content-Type: application/json; charset=utf-8');

if (!is_logged_in()) {
  http_response_code(401);
  echo json_encode(['ok' => false, 'error' => 'Unauthorised. Please login.']);
  exit;
}

$pdo = db();
$userId = current_user_id();

$action = (string)($_GET['action'] ?? $_POST['action'] ?? '');

function json_fail(int $code, string $message): void {
  http_response_code($code);
  echo json_encode(['ok' => false, 'error' => $message]);
  exit;
}

function ensure_trip_owner(PDO $pdo, int $tripId, int $userId): void {
  $stmt = $pdo->prepare('SELECT id FROM trips WHERE id = ? AND user_id = ? LIMIT 1');
  $stmt->execute([$tripId, $userId]);
  if (!$stmt->fetch()) json_fail(403, 'Forbidden: trip not found for this user.');
}

try {
  if ($action === 'listTrips') {
    $stmt = $pdo->prepare('SELECT id, title, start_date, end_date, created_at FROM trips WHERE user_id = ? ORDER BY created_at DESC');
    $stmt->execute([$userId]);
    echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
    exit;
  }

  if ($action === 'createTrip') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_fail(405, 'POST required.');
    if (!csrf_check()) json_fail(403, 'CSRF token invalid.');

    $title = trim((string)($_POST['title'] ?? ''));
    $start = (string)($_POST['start_date'] ?? '');
    $end = (string)($_POST['end_date'] ?? '');

    if ($title === '') json_fail(400, 'Trip title is required.');

    $stmt = $pdo->prepare('INSERT INTO trips (user_id, title, start_date, end_date) VALUES (?, ?, ?, ?)');
    $stmt->execute([$userId, $title, $start !== '' ? $start : null, $end !== '' ? $end : null]);

    echo json_encode(['ok' => true, 'data' => ['trip_id' => (int)$pdo->lastInsertId()]]);
    exit;
  }

  if ($action === 'listItems') {
    $tripId = (int)($_GET['trip_id'] ?? 0);
    if ($tripId <= 0) json_fail(400, 'trip_id is required.');
    ensure_trip_owner($pdo, $tripId, $userId);

    $stmt = $pdo->prepare('SELECT id, trip_id, item_type, item_date, start_time, destination, activity, notes, sort_order
                           FROM itinerary_items
                           WHERE trip_id = ?
                           ORDER BY item_date ASC, sort_order ASC, start_time ASC');
    $stmt->execute([$tripId]);

    echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
    exit;
  }

  if ($action === 'addItem') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_fail(405, 'POST required.');
    if (!csrf_check()) json_fail(403, 'CSRF token invalid.');

    $tripId = (int)($_POST['trip_id'] ?? 0);
    if ($tripId <= 0) json_fail(400, 'trip_id is required.');
    ensure_trip_owner($pdo, $tripId, $userId);

    $itemType = trim((string)($_POST['item_type'] ?? 'activity'));
    $allowed = ['destination', 'food', 'activity'];
    if (!in_array($itemType, $allowed, true)) $itemType = 'activity';

    $itemDate = trim((string)($_POST['item_date'] ?? ''));
    $startTime = trim((string)($_POST['start_time'] ?? ''));
    $destination = trim((string)($_POST['destination'] ?? ''));
    $activity = trim((string)($_POST['activity'] ?? ''));
    $notes = trim((string)($_POST['notes'] ?? ''));

    if ($itemDate === '' || $destination === '' || $activity === '') {
      json_fail(400, 'item_date, destination, and activity are required.');
    }

    $stmt = $pdo->prepare('SELECT COALESCE(MAX(sort_order), 0) + 1 AS next_sort
                           FROM itinerary_items WHERE trip_id = ? AND item_date = ?');
    $stmt->execute([$tripId, $itemDate]);
    $nextSort = (int)($stmt->fetch()['next_sort'] ?? 1);

    $stmt = $pdo->prepare('INSERT INTO itinerary_items
      (trip_id, item_type, item_date, start_time, destination, activity, notes, sort_order)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
      $tripId,
      $itemType,
      $itemDate,
      $startTime !== '' ? $startTime : null,
      $destination,
      $activity,
      $notes !== '' ? $notes : null,
      $nextSort
    ]);

    echo json_encode(['ok' => true, 'data' => ['item_id' => (int)$pdo->lastInsertId()]]);
    exit;
  }

  if ($action === 'deleteItem') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_fail(405, 'POST required.');
    if (!csrf_check()) json_fail(403, 'CSRF token invalid.');

    $itemId = (int)($_POST['item_id'] ?? 0);
    if ($itemId <= 0) json_fail(400, 'item_id is required.');

    $stmt = $pdo->prepare('SELECT ii.id FROM itinerary_items ii
                           JOIN trips t ON t.id = ii.trip_id
                           WHERE ii.id = ? AND t.user_id = ?');
    $stmt->execute([$itemId, $userId]);
    if (!$stmt->fetch()) json_fail(403, 'Forbidden: item not found for this user.');

    $stmt = $pdo->prepare('DELETE FROM itinerary_items WHERE id = ?');
    $stmt->execute([$itemId]);

    echo json_encode(['ok' => true]);
    exit;
  }

  json_fail(400, 'Unknown action.');
} catch (Throwable $e) {
  json_fail(500, APP_DEBUG ? ('Server error: ' . $e->getMessage()) : 'Server error.');
}
