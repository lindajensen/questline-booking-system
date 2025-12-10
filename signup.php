<?php
  session_start();

  $pageTitle = 'Questline Bookings | Sign Up';
  $error = '';

  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/User.php';

  // Signup form submission
  if (isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if ($name === '') {
      $error = "Name cannot be empty.";
    } elseif ($username === '') {
      $error = "Username cannot be empty.";
    } elseif ($password === '') {
      $error = "Password cannot be empty.";
    } else {
      $users = loadUsers('data/users.json');
      $duplicate_username = false;

      // Check for duplicate users
      foreach ($users as $user) {
        if (strcasecmp($user->username, $username) === 0) {
          $duplicate_username = true;
          break;
        }
      }

      if ($duplicate_username) {
        $error = "User with this username already exists.";
      } else {
        $new_user = new User(
          getNextId($users),
          $name,
          $username,
          hashPassword($password)
        );

        $users[] = $new_user;

        // Log in directly
        $_SESSION['user_id'] = $new_user->id;
        $_SESSION['name'] = $new_user->name;

        saveUsers('data/users.json', $users);

        header('Location: dashboard.php');
        exit;
      }
    }
  }

  require_once __DIR__. '/includes/header.php';
?>

<div class="login-form">
  <h1 class="login-form__title">Sign Up</h1>

  <?php if ($error): ?><p class="login-form__error" role="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form class="login-form__form" method="POST">
    <div class="login-form__group">
      <label for="name" class="login-form__label">Full Name</label>
      <input class="login-form__input" id="name" type="text" name="name">
    </div>

    <div class="login-form__group">
      <label for="username" class="login-form__label">Username</label>
      <input class="login-form__input" id="username" type="text" name="username">
    </div>

    <div class="login-form__group">
      <label for="password" class="login-form__label">Password</label>
      <input class="login-form__input" id="password" type="password" name="password">
    </div>

    <button type="submit" class="login-form__button" name="signup">Sign Up</button>
  </form>

  <p class="login-form__link">
    Already have an account? <a href="login.php">Log in here</a>
  </p>

</div>

<?php require_once __DIR__.'/includes/footer.php'; ?>
