<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="/css/style.css">
  <title><?= $pageTitle ?? 'Questline Bookings | Home' ?></title>
</head>
<body>
  <header class="header">
    <div class="header__container">
      <div class="header__logo">Questline Bookings</div>

      <?php if(isset($_SESSION['user_id'])): ?>
        <div class="header__user-info">Welcome <?= htmlspecialchars(getFirstName($_SESSION['name'])) ?></div>
      <?php endif; ?>

      <nav class="header__nav">
        <?php if(isset($_SESSION['user_id'])): ?>
          <a href="dashboard.php" class="header__link">Home</a>
        <?php else: ?>
          <a href="index.php" class="header__link">Home</a>
        <?php endif; ?>

          <a href="rooms.php" class="header__link">Rooms</a>
          <a href="users.php" class="header__link">Users</a>

        <?php if(isset($_SESSION['user_id'])): ?>
          <a href="logout.php" class="header__link header__link--button">Log Out</a>
        <?php else: ?>
          <a href="login.php" class="header__link header__link--button">Log In</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="main">
