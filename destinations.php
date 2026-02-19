<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Destinations';
$page_id = 'destinations';
$page_scripts = ['sl_data.js', 'destinations.js'];
include __DIR__ . '/partials/header.php';
?>

<section class="container py-5">
  <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
    <div class="reveal">
      <h1 class="h2 mb-1">Sri Lanka Destinations</h1>
      <p class="text-white-75 mb-0">Browse places and add them to your itinerary.</p>
    </div>

    <div class="reveal sl-glass p-3">
      <div class="row g-2">
        <div class="col-md-4">
          <label class="form-label small text-white-75" for="destCategory">Category</label>
          <select id="destCategory" class="form-select sl-input"></select>
        </div>
        <div class="col-md-4">
          <label class="form-label small text-white-75" for="destProvince">Province</label>
          <select id="destProvince" class="form-select sl-input"></select>
        </div>
        <div class="col-md-4">
          <label class="form-label small text-white-75" for="destSearch">Search</label>
          <input id="destSearch" type="search" class="form-control sl-input" placeholder="e.g., beach, UNESCO, tea">
        </div>
      </div>
      <div class="text-white-50 small mt-2"><span id="destCount"></span></div>
    </div>
  </div>

  <div class="row g-4 mt-2" id="destGrid"></div>
</section>

<div class="modal fade" id="destModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content sl-modal">
      <div class="modal-header border-0">
        <h5 id="destModalTitle" class="modal-title"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="destModalImg" class="img-fluid rounded-4 mb-3" alt="">
        <p id="destModalDesc" class="text-white-75 mb-2"></p>
        <div id="destModalMeta" class="text-white-50 small"></div>
      </div>
      <div class="modal-footer border-0">
        <button id="destQuickAdd" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Quick add to Planner</button>
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
