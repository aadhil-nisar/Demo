<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Features';
$page_id = 'features';
include __DIR__ . '/partials/header.php';
?>

<section class="container py-5">
  <div class="row g-4">
    <div class="col-lg-4 reveal">
      <div class="sl-card p-4 position-sticky" style="top: 6rem;">
        <h1 class="h4 mb-3">Features</h1>
        <div id="featuresNav" class="list-group">
          <a class="list-group-item list-group-item-action sl-list" href="#overview">Overview</a>
          <a class="list-group-item list-group-item-action sl-list" href="#js">JavaScript</a>
          <a class="list-group-item list-group-item-action sl-list" href="#backend">Backend</a>
          <a class="list-group-item list-group-item-action sl-list" href="#accessibility">Accessibility</a>
        </div>
        <div class="text-white-75 small mt-3">Scrollspy highlights the current section while scrolling.</div>
      </div>
    </div>

    <div class="col-lg-8 reveal">
      <div data-bs-spy="scroll" data-bs-target="#featuresNav" data-bs-smooth-scroll="true"
           class="sl-scrollspy p-4 sl-card" tabindex="0">

        <section id="overview" class="sl-section">
          <h2 class="h4">Overview</h2>
          <p class="text-white-75 mb-0">
            A Sri Lanka itinerary planner with a destination + food catalogue, day‑by‑day timeline, and full‑stack storage.
          </p>
        </section>

        <section id="js" class="sl-section">
          <h2 class="h4">JavaScript features</h2>
          <p class="text-white-75">
            Search/filter destinations and foods, quick‑add items to the Planner, and update the itinerary without reloading using Fetch.
          </p>
        </section>

        <section id="backend" class="sl-section">
          <h2 class="h4">Backend features</h2>
          <p class="text-white-75 mb-0">
            User registration/login, create trips, add/delete itinerary items with secure session handling and password hashing.
          </p>
        </section>

        <section id="accessibility" class="sl-section">
          <h2 class="h4">Accessibility</h2>
          <p class="text-white-75 mb-0">
            Animations are disabled when the user prefers reduced motion and forms provide clear validation feedback.
          </p>
        </section>

      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
