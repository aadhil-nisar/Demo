<?php
require_once __DIR__ . '/config/app.php';
require_login();

$page_title = 'Dashboard';
$page_id = 'dashboard';

$stmt = db()->prepare('SELECT id, title, start_date, end_date, created_at FROM trips WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([current_user_id()]);
$trips = $stmt->fetchAll();

include __DIR__ . '/partials/header.php';
?>

<section class="container py-5">
  <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
    <div class="reveal">
      <h1 class="h2 mb-1">Dashboard</h1>
      <p class="text-white-75 mb-0">Your saved trips (MySQL).</p>
    </div>
    <div class="reveal">
      <a class="btn btn-primary" href="planner.php"><i class="bi bi-plus-circle"></i> Open planner</a>
    </div>
  </div>

  <div class="row g-4 mt-2">
    <?php if (!$trips): ?>
      <div class="col-12 reveal">
        <div class="sl-card p-4">
          <p class="text-white-75 mb-0">No trips yet. Create one in the Planner.</p>
        </div>
      </div>
    <?php endif; ?>

    <?php foreach ($trips as $t): ?>
      <div class="col-md-6 col-lg-4 reveal">
        <div class="sl-card p-4 h-100">
          <h2 class="h5 mb-2"><?= e($t['title']) ?></h2>
          <div class="text-white-75 small">
            <i class="bi bi-calendar-week"></i>
            <?= e((string)($t['start_date'] ?? '')) ?> → <?= e((string)($t['end_date'] ?? '')) ?>
          </div>
          <div class="mt-3">
            <a class="btn btn-outline-light btn-sm" href="planner.php"><i class="bi bi-pencil"></i> Edit in planner</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
