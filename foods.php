<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Foods';
$page_id = 'foods';
$page_scripts = ['sl_data.js', 'foods.js'];
include __DIR__ . '/partials/header.php';
?>

<section class="container py-5">
  <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
    <div class="reveal">
      <h1 class="h2 mb-1">Sri Lankan Foods</h1>
      <p class="text-white-75 mb-0">Explore iconic dishes and add food stops to your plan.</p>
    </div>

    <div class="reveal sl-glass p-3">
      <div class="row g-2">
        <div class="col-md-4">
          <label class="form-label small text-white-75" for="foodMeal">Meal</label>
          <select id="foodMeal" class="form-select sl-input"></select>
        </div>
        <div class="col-md-4">
          <label class="form-label small text-white-75" for="foodRegion">Region</label>
          <select id="foodRegion" class="form-select sl-input"></select>
        </div>
        <div class="col-md-4">
          <label class="form-label small text-white-75" for="foodSearch">Search</label>
          <input id="foodSearch" type="search" class="form-control sl-input" placeholder="e.g., hoppers, sambol, sweet">
        </div>
      </div>
      <div class="text-white-50 small mt-2"><span id="foodCount"></span></div>
    </div>
  </div>

  <div class="row g-4 mt-2" id="foodGrid"></div>
</section>

<div class="modal fade" id="foodModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content sl-modal">
      <div class="modal-header border-0">
        <h5 id="foodModalTitle" class="modal-title"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="foodModalImg" class="img-fluid rounded-4 mb-3" alt="">
        <p id="foodModalDesc" class="text-white-75 mb-2"></p>
        <div id="foodModalMeta" class="text-white-50 small"></div>
      </div>
      <div class="modal-footer border-0">
        <button id="foodQuickAdd" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Quick add to Planner</button>
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
