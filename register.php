<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Sign up';
$page_id = 'register';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_check()) {
    flash_set('Security check failed. Please try again.', 'warning');
    header('Location: register.php'); exit;
  }

  $name = trim((string)($_POST['name'] ?? ''));
  $email = strtolower(trim((string)($_POST['email'] ?? '')));
  $password = (string)($_POST['password'] ?? '');
  $confirm = (string)($_POST['confirm'] ?? '');

  $errors = [];
  if ($name === '') $errors[] = 'Name is required.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email is invalid.';
  if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
  if ($password !== $confirm) $errors[] = 'Passwords do not match.';

  if (!$errors) {
    $stmt = db()->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($stmt->fetch()) $errors[] = 'An account with this email already exists.';
  }

  if ($errors) {
    flash_set(implode(' ', $errors), 'danger');
    header('Location: register.php'); exit;
  }

  $hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = db()->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
  $stmt->execute([$name, $email, $hash]);

  flash_set('Account created! Please login.', 'success');
  header('Location: login.php'); exit;
}

include __DIR__ . '/partials/header.php';
?>

<section class="container py-5" style="max-width: 760px;">
  <div class="sl-card p-4 reveal">
    <h1 class="h3 mb-2">Create your account</h1>
    <p class="text-white-75">Save your trips and access them later.</p>

    <form class="needs-validation" method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

      <div class="mb-3">
        <label class="form-label" for="rName">Name</label>
        <input id="rName" name="name" class="form-control sl-input" required>
        <div class="invalid-feedback">Name is required.</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="rEmail">Email</label>
        <input id="rEmail" name="email" type="email" class="form-control sl-input" required>
        <div class="invalid-feedback">Enter a valid email.</div>
      </div>

      <div class="row g-2">
        <div class="col-md-6">
          <label class="form-label" for="rPass">Password</label>
          <input id="rPass" name="password" type="password" class="form-control sl-input" required minlength="8">
          <div class="invalid-feedback">Min 8 characters.</div>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="rConfirm">Confirm password</label>
          <input id="rConfirm" name="confirm" type="password" class="form-control sl-input" required minlength="8">
          <div class="invalid-feedback">Please confirm.</div>
        </div>
      </div>

      <button class="btn btn-primary mt-3" type="submit"><i class="bi bi-person-plus"></i> Sign up</button>
      <a class="btn btn-outline-light mt-3 ms-2" href="login.php">Already have an account?</a>
    </form>
  </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
