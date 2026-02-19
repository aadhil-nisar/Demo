<?php
require_once __DIR__ . '/config/app.php';
$page_title = 'Home';
$page_id = 'home';
include __DIR__ . '/partials/header.php';
?>

<section id="home" class="sl-hero">
  <div class="container py-5">
    <div class="row align-items-center g-4 py-4">
      <div class="col-lg-6 reveal">
        <span class="badge text-bg-light sl-badge mb-3">
          <i class="bi bi-compass"></i> Sri Lanka Itinerary Planner
        </span>
        <h1 class="display-5 fw-bold">Plan Sri Lanka beautifully.</h1>
        <p class="lead text-white-75">
          Build a day‑by‑day trip with destinations, foods, and notes—then save it with login.
        </p>

        <div class="d-flex flex-wrap gap-2">
          <a href="planner.php" class="btn btn-primary btn-lg">
            <i class="bi bi-calendar2-check"></i> Start planning
          </a>
          <a href="destinations.php" class="btn btn-outline-light btn-lg">
            <i class="bi bi-map"></i> Explore places
          </a>
          <a href="foods.php" class="btn btn-outline-light btn-lg">
            <i class="bi bi-egg-fried"></i> Explore foods
          </a>
        </div>

        <div class="mt-4 d-flex flex-wrap gap-3 text-white-75 small">
          <div><i class="bi bi-lightning-charge"></i> Instant updates</div>
          <div><i class="bi bi-stars"></i> Smooth animations</div>
          <div><i class="bi bi-shield-lock"></i> Secure login</div>
        </div>
      </div>

      <div class="col-lg-6 reveal">
        <div class="sl-glass p-3">
          <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner rounded-4 overflow-hidden">
              <div class="carousel-item active">
                <img class="d-block w-100 sl-carousel-img"
                     src="https://images.unsplash.com/photo-1544735716-17f32a0b9f49?auto=format&fit=crop&w=1600&q=80"
                     alt="Sri Lanka scenery">
                <div class="carousel-caption text-start">
                  <h5>Destinations</h5>
                  <p>Heritage • Beaches • Hill Country</p>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100 sl-carousel-img"
                     src="https://images.unsplash.com/photo-1543689870-5f4d2a6a58b5?auto=format&fit=crop&w=1600&q=80"
                     alt="Sri Lanka tea country">
                <div class="carousel-caption">
                  <h5>Tea country</h5>
                  <p>Nuwara Eliya • Ella • Haputale</p>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100 sl-carousel-img"
                     src="https://images.unsplash.com/photo-1532634896-26909d0d4b1b?auto=format&fit=crop&w=1600&q=80"
                     alt="Sri Lankan food">
                <div class="carousel-caption text-end">
                  <h5>Foods</h5>
                  <p>Hoppers • Kottu • Rice & curry</p>
                </div>
              </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

          <div class="mt-3 text-white-75 small">
            Placeholder images: internet (Unsplash). Replace with your own assets later.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container py-5">
  <div class="row g-4">
    <div class="col-md-4 reveal">
      <div class="sl-card h-100 p-4">
        <div class="sl-icon"><i class="bi bi-calendar-week"></i></div>
        <h2 class="h5 mt-3">Date‑based itinerary</h2>
        <p class="text-white-75 mb-0">Add items by date and instantly view a day‑by‑day timeline.</p>
      </div>
    </div>
    <div class="col-md-4 reveal">
      <div class="sl-card h-100 p-4">
        <div class="sl-icon"><i class="bi bi-filter"></i></div>
        <h2 class="h5 mt-3">Filter & quick‑add</h2>
        <p class="text-white-75 mb-0">Search destinations and foods, then send them to the Planner with one click.</p>
      </div>
    </div>
    <div class="col-md-4 reveal">
      <div class="sl-card h-100 p-4">
        <div class="sl-icon"><i class="bi bi-database-check"></i></div>
        <h2 class="h5 mt-3">Saved in MySQL</h2>
        <p class="text-white-75 mb-0">Login to store your trip and retrieve it later (full‑stack proof).</p>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
