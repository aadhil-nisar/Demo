<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Login';
$page_id = 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_check()) {
    flash_set('Security check failed. Please try again.', 'warning');
    header('Location: login.php'); exit;
  }

  $email = strtolower(trim((string)($_POST['email'] ?? '')));
  $password = (string)($_POST['password'] ?? '');

  $stmt = db()->prepare('SELECT id, password_hash FROM users WHERE email = ? LIMIT 1');
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password_hash'])) {
    login_user((int)$user['id']);
    $redirect = $_SESSION['redirect_after_login'] ?? 'planner.php';
    unset($_SESSION['redirect_after_login']);
    flash_set('Welcome back!', 'success');
    header('Location: ' . $redirect);
    exit;
  }

  flash_set('Invalid email or password.', 'danger');
  header('Location: login.php'); exit;
}

include __DIR__ . '/partials/header.php';
?>

<section class="container py-5" style="max-width: 760px;">
  <div class="sl-card p-4 reveal">
    <h1 class="h3 mb-2">Login</h1>
    <p class="text-white-75">Access your saved trips.</p>

    <form class="needs-validation" method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

      <div class="mb-3">
        <label class="form-label" for="lEmail">Email</label>
        <input id="lEmail" name="email" type="email" class="form-control sl-input" required>
        <div class="invalid-feedback">Enter your email.</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="lPass">Password</label>
        <input id="lPass" name="password" type="password" class="form-control sl-input" required>
        <div class="invalid-feedback">Password is required.</div>
      </div>

      <button class="btn btn-primary" type="submit"><i class="bi bi-box-arrow-in-right"></i> Login</button>
      <a class="btn btn-outline-light ms-2" href="register.php">Create account</a>
    </form>
  </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
