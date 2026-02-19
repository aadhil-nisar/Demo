</main>

<footer class="sl-footer mt-5">
  <div class="container py-4">
    <div class="row g-3 align-items-center">
      <div class="col-md">
        <div class="d-flex align-items-center gap-2">
          <span class="sl-logo sl-logo-sm" aria-hidden="true"></span>
          <strong><?= APP_NAME ?></strong>
        </div>
        <div class="text-white-50 small">
          A full‑stack student project (Bootstrap + JS + PHP + MySQL).
        </div>
      </div>
      <div class="col-md-auto">
        <div class="text-white-50 small">© <?= date('Y') ?> • Sri Lanka Planner</div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/animations.js"></script>
<script src="assets/js/app.js"></script>

<?php if (!empty($page_scripts) && is_array($page_scripts)): ?>
  <?php foreach ($page_scripts as $script): ?>
    <script src="assets/js/<?= e($script) ?>"></script>
  <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
