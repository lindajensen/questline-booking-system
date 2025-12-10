<!-- Add User -->
<?php
  session_start();

  $pageTitle = 'Questline Bookings | Create User';
  $error = '';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/User.php';

    // Handle new user submission
  if (isset($_POST['add_user'])) {
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

      // Check if user with that username exists
      foreach ($users as $user) {
        if (strcasecmp($user->username, $username) === 0) {
          $duplicate_username = true;
          break;
        }
      }

      if ($duplicate_username) {
        $error = "User with this username already exists.";
      } else {
        // Create new user
        $new_user = new User(
          getNextId($users),
          $name,
          $username,
          hashPassword($password)
        );

        $users[] = $new_user;

        saveUsers('data/users.json', $users);

        header('Location: users.php');
        exit;
      }
    }
  }

  require_once __DIR__. '/includes/header.php';
?>

<section class="login-form">
  <h1 class="login-form__title">Create New User</h1>

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

    <button type="submit" class="login-form__button" name="add_user">Add User</button>
  </form>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
