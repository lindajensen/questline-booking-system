<!-- Log Out -->
<?php
  session_start();

  $_SESSION = [];

  session_destroy();

  setcookie('userid', '', time()-3600, '/');

  $pageTitle = 'Questline Bookings | Log Out';

  require_once __DIR__. '/includes/header.php';
?>

<div class="logout">
  <div class="logout__banner">
    <div class="logout__icon" aria-hidden="true">
      <i data-lucide="circle-check-big"></i>
    </div>
  </div>

  <div class="logout__content">
    <h2 class="logout__title">See You Later!</h2>
    <p class="logout__message">You have been successfully logged out.</p>
    <a href="login.php" class="logout__button">Log In Again</a>
  </div>
</div>

<?php require_once __DIR__.'/includes/footer.php'; ?>
