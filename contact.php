<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Contact';
$page_id = 'contact';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_check()) {
    flash_set('Security check failed. Please try again.', 'warning');
    header('Location: contact.php'); exit;
  }

  $name = trim((string)($_POST['name'] ?? ''));
  $email = trim((string)($_POST['email'] ?? ''));
  $subject = trim((string)($_POST['subject'] ?? ''));
  $message = trim((string)($_POST['message'] ?? ''));

  $errors = [];
  if ($name === '') $errors[] = 'Name is required.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email is invalid.';
  if ($subject === '') $errors[] = 'Subject is required.';
  if ($message === '') $errors[] = 'Message is required.';

  if ($errors) {
    flash_set(implode(' ', $errors), 'danger');
    header('Location: contact.php'); exit;
  }

  $stmt = db()->prepare('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)');
  $stmt->execute([$name, $email, $subject, $message]);

  flash_set('Message saved to MySQL. Thank you!', 'success');
  header('Location: contact.php'); exit;
}

include __DIR__ . '/partials/header.php';
?>

<section class="container py-5" style="max-width: 900px;">
  <div class="sl-card p-4 reveal">
    <h1 class="h2 mb-2">Contact</h1>
    <p class="text-white-75">Validated form + stored in database (full‑stack proof).</p>

    <form class="needs-validation" method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

      <div class="mb-3">
        <label class="form-label" for="cName">Name</label>
        <input id="cName" name="name" class="form-control sl-input" required>
        <div class="invalid-feedback">Please enter your name.</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="cEmail">Email</label>
        <input id="cEmail" name="email" type="email" class="form-control sl-input" required>
        <div class="invalid-feedback">Please enter a valid email.</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="cSubject">Subject</label>
        <input id="cSubject" name="subject" class="form-control sl-input" required>
        <div class="invalid-feedback">Subject is required.</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="cMsg">Message</label>
        <textarea id="cMsg" name="message" class="form-control sl-input" rows="5" required></textarea>
        <div class="invalid-feedback">Please type a message.</div>
      </div>

      <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i> Send</button>
    </form>
  </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
