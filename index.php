<!-- Landing Page - Not logged in -->
<?php
  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
  }

  $pageTitle = 'Questline Bookings | Welcome';

  require_once 'includes/header.php';
?>

  <div class="landing">
    <header class="landing__hero">
      <img class="landing__hero-image" src="/assets/images/landing-hero.jpg" alt="Sunfall Meeting Room">
      <h1 class="landing__title">Questline Bookings</h1>
      <p class="landing__subtitle">Your adventure in meeting room management begins here</p>
    </header>

    <section class="landing__features">
      <article class="landing__feature-card">
        <div class="landing__feature-icon">
          <i data-lucide="castle" aria-hidden="true"></i>
        </div>

        <h3 class="landing__feature-title">Epic Spaces</h3>
        <p class="landing__feature-text">Book unique rooms inspired by your favorite games.</p>
      </article>

      <article class="landing__feature-card">
        <div class="landing__feature-icon">
          <i data-lucide="calendar" aria-hidden="true"></i>
        </div>
        <h3 class="landing__feature-title">Easy Booking</h3>
        <p class="landing__feature-text">Quick and simple reservation system. Book your slot in seconds.</p>
      </article>

      <article class="landing__feature-card">
        <div class="landing__feature-icon">
          <i data-lucide="chart-line" aria-hidden="true"></i>
        </div>
        <h3 class="landing__feature-title">Track Progress</h3>
        <p class="landing__feature-text">View all your bookings in one dashboard. Stay organized without effort.</p>
      </article>
    </section>

    <section class="landing__cta">
      <a href="signup.php" class="landing__cta-button">Join the Adventure</a>
    </section>
  </div>

<?php require_once 'includes/footer.php'; ?>
