<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Planner';
$page_id = 'planner';
$page_scripts = ['sl_data.js', 'planner.js'];
include __DIR__ . '/partials/header.php';
?>

<section class="container py-5">
  <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
    <div class="reveal">
      <h1 class="h2 mb-1">Itinerary Planner</h1>
      <p class="text-white-75 mb-0">Add destinations, activities, foods, and notes by date.</p>
    </div>
    <div class="reveal">
      <?php if (!is_logged_in()): ?>
        <div class="sl-glass p-3">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-lock"></i>
            <div>
              <div class="fw-semibold">Login required to save</div>
              <div class="small text-white-75">Register/login to store trips in MySQL.</div>
            </div>
          </div>
          <div class="mt-2">
            <a class="btn btn-sm btn-primary" href="login.php">Login</a>
            <a class="btn btn-sm btn-outline-light ms-1" href="register.php">Sign up</a>
          </div>
        </div>
      <?php else: ?>
        <span class="badge text-bg-success"><i class="bi bi-cloud-check"></i> Saving to database</span>
      <?php endif; ?>
    </div>
  </div>

  <div class="row g-4 mt-3">
    <div class="col-lg-4 reveal">
      <div class="sl-card p-4">
        <h2 class="h5 mb-3"><i class="bi bi-briefcase"></i> Trips</h2>

        <?php if (is_logged_in()): ?>
          <label class="form-label text-white-75" for="tripSelect">Select a trip</label>
          <select class="form-select sl-input mb-3" id="tripSelect">
            <option value="">Loading…</option>
          </select>

          <hr class="border-white border-opacity-25">

          <h3 class="h6 mb-3 text-white-75">Create new trip</h3>
          <form id="createTripForm" class="needs-validation" novalidate>
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <div class="mb-3">
              <label class="form-label" for="tripTitle">Trip title</label>
              <input id="tripTitle" name="title" type="text" class="form-control sl-input" required
                     placeholder="e.g., 7 Days Sri Lanka Explorer">
              <div class="invalid-feedback">Please enter a trip title.</div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label" for="tripStart">Start date</label>
                <input id="tripStart" name="start_date" type="date" class="form-control sl-input">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="tripEnd">End date</label>
                <input id="tripEnd" name="end_date" type="date" class="form-control sl-input">
              </div>
            </div>

            <button class="btn btn-primary w-100 mt-3" type="submit">
              <i class="bi bi-plus-circle"></i> Create trip
            </button>
          </form>
        <?php else: ?>
          <p class="text-white-75 mb-0">Login to create trips and store them in the database.</p>
        <?php endif; ?>
      </div>

      <div class="sl-card p-4 mt-4">
        <h2 class="h5 mb-3"><i class="bi bi-signpost"></i> Jump to day</h2>
        <div id="dayJumpList" class="d-grid gap-2 small text-white-75">
          <div>Select a trip to generate day links.</div>
        </div>
      </div>
    </div>

    <div class="col-lg-8 reveal">
      <div class="sl-card p-4">
        <h2 class="h5 mb-3"><i class="bi bi-calendar2-plus"></i> Add itinerary item</h2>

        <?php if (is_logged_in()): ?>
          <form id="addItemForm" class="needs-validation" novalidate>
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

            <div class="row g-2">
              <div class="col-md-4">
                <label class="form-label" for="itemType">Type</label>
                <select id="itemType" name="item_type" class="form-select sl-input" required>
                  <option value="destination">Destination</option>
                  <option value="food">Food</option>
                  <option value="activity">Activity</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="itemDate">Date</label>
                <input id="itemDate" name="item_date" type="date" class="form-control sl-input" required>
                <div class="invalid-feedback">Pick a date.</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="startTime">Start</label>
                <input id="startTime" name="start_time" type="time" class="form-control sl-input">
              </div>
            </div>

            <div class="row g-2 mt-1">
              <div class="col-md-6">
                <label class="form-label" for="destination">Destination / Place</label>
                <input id="destination" name="destination" type="text" class="form-control sl-input" required
                       placeholder="e.g., Sigiriya">
                <div class="invalid-feedback">Destination/place is required.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="activity">Activity / Food</label>
                <input id="activity" name="activity" type="text" class="form-control sl-input" required
                       placeholder="e.g., Climb at sunrise">
                <div class="invalid-feedback">This field is required.</div>
              </div>
            </div>

            <div class="mt-2">
              <label class="form-label" for="notes">Notes</label>
              <textarea id="notes" name="notes" class="form-control sl-input" rows="3"
                        placeholder="Optional notes…"></textarea>
            </div>

            <button id="addItemBtn" class="btn btn-primary mt-3" type="submit" disabled
                    data-bs-toggle="tooltip" data-bs-title="Select a trip first">
              <i class="bi bi-plus-circle"></i> Add to itinerary
            </button>
          </form>
        <?php else: ?>
          <p class="text-white-75 mb-0">Login to add items and save them.</p>
        <?php endif; ?>
      </div>

      <div class="sl-card p-4 mt-4">
        <div class="d-flex align-items-center justify-content-between gap-2">
          <h2 class="h5 mb-0"><i class="bi bi-list-check"></i> Your itinerary</h2>
          <span id="tripMeta" class="text-white-75 small"></span>
        </div>

        <div id="itemsContainer" class="mt-3">
          <div class="text-white-75">Select a trip to load itinerary items.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="slToast" class="toast sl-toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-transparent text-white border-0">
      <i class="bi bi-bell me-2"></i>
      <strong class="me-auto"><?= APP_NAME ?></strong>
      <small class="text-white-50">now</small>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div id="slToastBody" class="toast-body text-white-75"></div>
  </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
