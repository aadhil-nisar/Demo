<?php
declare(strict_types=1);

const APP_NAME = 'Sri Lanka Explorer';
const APP_DEBUG = true;

// XAMPP defaults
const DB_HOST = '127.0.0.1';
const DB_NAME = 'sl_explorer';
const DB_USER = 'root';
const DB_PASS = '';

const SESSION_NAME = 'sl_explorer_session';

if (APP_DEBUG) {
  ini_set('display_errors', '1');
  ini_set('display_startup_errors', '1');
  error_reporting(E_ALL);
} else {
  ini_set('display_errors', '0');
}

session_name(SESSION_NAME);
session_start();

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

try {
  $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
  $pdo = new PDO($dsn, DB_USER, DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]);
} catch (Throwable $e) {
  http_response_code(500);
  echo '<h1>Database connection failed</h1>';
  if (APP_DEBUG) {
    echo '<pre>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</pre>';
  }
  exit;
}

// Helpers
function db(): PDO { global $pdo; return $pdo; }

function e(string $v): string {
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string {
  return $_SESSION['csrf_token'] ?? '';
}

function csrf_check(): bool {
  $submitted = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
  $stored = $_SESSION['csrf_token'] ?? '';
  return is_string($submitted) && $stored !== '' && hash_equals($stored, (string)$submitted);
}

function flash_set(string $msg, string $type = 'info'): void {
  $_SESSION['flash'] = ['message' => $msg, 'type' => $type];
}

function flash_get(): ?array {
  if (empty($_SESSION['flash'])) return null;
  $f = $_SESSION['flash'];
  unset($_SESSION['flash']);
  return $f;
}

function is_logged_in(): bool {
  return !empty($_SESSION['user_id']);
}

function current_user_id(): ?int {
  return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

function login_user(int $id): void {
  session_regenerate_id(true);
  $_SESSION['user_id'] = $id;
}

function logout_user(): void {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params['path'] ?? '/',
      $params['domain'] ?? '',
      (bool)($params['secure'] ?? false),
      (bool)($params['httponly'] ?? true)
    );
  }
  session_destroy();
}

function require_login(): void {
  if (!is_logged_in()) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? 'planner.php';
    header('Location: login.php');
    exit;
  }
}
