<?php
$page_title = $page_title ?? '';
$page_id = $page_id ?? '';
$full_title = ($page_title ? e($page_title) . ' | ' : '') . APP_NAME;
?>
<!doctype html>
<html lang="en-GB" data-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
  <title><?= $full_title ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="sl-body" data-page="<?= e($page_id) ?>">
<a class="skip-link" href="#main">Skip to content</a>

<nav class="navbar navbar-expand-lg sl-navbar fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <span class="sl-logo" aria-hidden="true"></span>
      <span><?= APP_NAME ?></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#slNav"
            aria-controls="slNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="slNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="destinations.php">Destinations</a></li>
        <li class="nav-item"><a class="nav-link" href="foods.php">Foods</a></li>
        <li class="nav-item"><a class="nav-link" href="planner.php">Planner</a></li>
        <li class="nav-item"><a class="nav-link" href="features.php">Features</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>

      <div class="d-flex align-items-center gap-2">
        <button id="themeToggle" type="button" class="btn btn-sm btn-outline-light"
                data-bs-toggle="tooltip" data-bs-title="Toggle theme">
          <i class="bi bi-moon-stars"></i>
        </button>

        <?php if (is_logged_in()): ?>
          <a class="btn btn-sm btn-outline-light" href="dashboard.php"><i class="bi bi-grid"></i> Dashboard</a>
          <a class="btn btn-sm btn-warning" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        <?php else: ?>
          <a class="btn btn-sm btn-outline-light" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
          <a class="btn btn-sm btn-primary" href="register.php"><i class="bi bi-person-plus"></i> Sign up</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main id="main" class="sl-main">
  <div class="container pt-3">
    <?php $flash = flash_get(); ?>
    <?php if ($flash): ?>
      <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
        <?= e($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
  </div>
