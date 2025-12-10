<!-- Login Page -->
<?php
session_start();

require_once __DIR__.'/includes/functions.php';
require_once __DIR__.'/classes/User.php';

$pageTitle = 'Questline Bookings | Log In';
$error = '';

// Login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  // Validation
  if ($username === "" || $password === "") {
    $error = 'Both username and password are required to log in';
  } else {
    $users = loadUsers('data/users.json');
    $found_user = null;

    // Find matching username
    foreach ($users as $user) {
      if ($user->username === $username) {
        $found_user = $user;
        break;
      }
    }

    // Verify password
    if ($found_user && verifyPassword($password, $found_user->passwordHash)) {
      $_SESSION['user_id'] = $found_user->id;
      $_SESSION['name'] = $found_user->name;

      // Set remember me cookie if checked
      if (isset($_POST['remember_me'])) {
        setcookie('userid', (string)$found_user->id, [
          'expires'  => time() + 3600*8,
          'path'     => '/',
          'secure'   => !empty($_SERVER['HTTPS']),
          'httponly' => true,
          'samesite' => 'Lax'
        ]);
      }

      header('Location: dashboard.php');
      exit;
    } else {
      $error = 'Incorrect username or password';
    }
  }
}

require_once __DIR__.'/includes/header.php';
?>

<div class="login-form">
  <h1 class="login-form__title">Welcome Back!</h1>
  <p class="login-form__subtitle">Log in level up your meetings</p>

  <?php if ($error): ?><p class="login-form__error" role="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form class="login-form__form" method="POST">
    <div class="login-form__group">
      <label for="username" class="login-form__label">Username</label>
      <input
        type="text"
        id="username"
        name="username"
        class="login-form__input"
      >
    </div>

    <div class="login-form__group">
      <label for="password" class="login-form__label">Password</label>
      <input
        type="password"
        id="password"
        name="password"
        class="login-form__input"
      >
    </div>

    <div class="login-form__group login-form__group--checkbox">
      <label class="login-form__checkbox-label">
        <input
          type="checkbox"
          name="remember_me"
          class="login-form__checkbox"
        >
        Remember me
      </label>
    </div>

    <button type="submit" class="login-form__button">Log In</button>
  </form>

  <p class="login-form__link">
    Don't have an account? <a href="signup.php">Create one here</a>
  </p>
</div>

<?php require_once __DIR__.'/includes/footer.php'; ?>

<!-- https://www.php.net/manual/en/function.unset.php -->
