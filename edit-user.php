<?php
  session_start();

  $pageTitle = 'Questline Bookings | Edit User';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/User.php';

  $id = (int)($_GET['id'] ?? 0);

  $users = loadUsers('data/users.json');

  $user_to_edit = null;

  // Finds the user to edit based on its ID.
  foreach($users as $user) {
    if ($user->id === $id) {
      $user_to_edit = $user;
      break;
    }
  }

  if ($user_to_edit === null) {
    header('Location: users.php');
    exit;
  }

   // Updates an existing user after submitting the form data
  if (isset($_POST['edit_user'])) {
    foreach($users as &$user) {
      if ($user->id === $id) {
        $user->name = $_POST['name'];
        $user->username= $_POST['username'];

        if (!empty($_POST['password'])) {
          $user->passwordHash = hashPassword($_POST['password']);
        }
      }
    }

    saveUsers('data/users.json', $users);

    header('Location: users.php');
    exit;
  }

  require_once __DIR__. '/includes/header.php';
?>

<div class="login-form">
  <h1 class="login-form__title">Edit User</h1>

  <form class="login-form__form" method="POST">
      <div class="login-form__group">
        <input type="hidden" name="user_id" value="<?= $user_to_edit->id ?>">
      </div>

      <div class="login-form__group">
        <label for="name" class="login-form__label">Full Name</label>
        <input class="login-form__input" id="name" type="text" name="name" value="<?= $user_to_edit->name ?>">
      </div>

      <div class="login-form__group">
        <label for="username" class="login-form__label">Username</label>
        <input class="login-form__input" id="username" type="text" name="username" value="<?= $user_to_edit->username ?>">
      </div>

      <div class="login-form__group">
        <label for="password" class="login-form__label">Password</label>
        <input class="login-form__input" id="password" type="password" name="password" aria-describedby="passwordHelp">
        <small id="passwordHelp" class="login-form__help">Leave blank to keep current password</small>
      </div>

      <button type="submit" class="login-form__button" name="edit_user">Update User</button>
  </form>
</div>

<?php require_once __DIR__.'/includes/footer.php'; ?>
