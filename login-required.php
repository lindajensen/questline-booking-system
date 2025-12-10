<?php
  session_start();

  $pageTitle = 'Questline Bookings | Login Required';

  require_once __DIR__.'/includes/header.php';
?>

  <section class="login-required">
    <div class="login-required__icon" aria-hidden="true">
      <i data-lucide="lock"></i>
    </div>

    <h1 class="login-required__title">Login Required</h1>
    <p class="login-required__subtitle">
      You need to be logged in to access this feature
    </p>

    <a href="login.php" class="login-required__button">Go to Login</a>
  </section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
