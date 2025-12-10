<!-- Edit Room Page -->
<?php
  session_start();

  $pageTitle = 'Questline Bookings | Edit Room';
  $error = '';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/Room.php';

  $id = (int)($_GET['id'] ?? 0);

  $rooms = loadRooms('data/rooms.json');

  $room_to_edit = null;

  // Finds the room to edit based on its ID.
  foreach($rooms as $room) {
    if ($room->id === $id) {
      $room_to_edit = $room;
      break;
    }
  }

  if ($room_to_edit === null) {
    header('Location: rooms.php');
    exit;
  }

  // Updates an existing room after validating the submitted form data.
  if (isset($_POST['edit_room'])) {
    $name = trim($_POST['name']);
    $seats = (int)($_POST['seats'] ?? 0);

    // Validation
    if ($name === '') {
      $error = "Room name cannot be empty.";
    } elseif ($seats <= 0) {
      $error = "Seats must be a positive number.";
    } else {
      foreach($rooms as &$room) {
        if ($room->id === $id) {
          $room->name = $_POST['name'];
          $room->seats = (int)$_POST['seats'];
          $room->has_tv = isset($_POST['has_tv']);
          $room->has_audio = isset($_POST['has_audio']);
        }
      }

      saveRooms('data/rooms.json', $rooms);

      header('Location: rooms.php');
      exit;
    }
  }

  require_once __DIR__. '/includes/header.php';
?>

<div class="login-form">
  <h1 class="login-form__title">Edit Room</h1>

  <?php if ($error): ?><p class="login-form__error" role="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form class="login-form__form" method="POST">
      <div class="login-form__group">
        <input type="hidden" name="room_id" value="<?= $room->id ?>">
      </div>

      <div class="login-form__group">
        <label for="name" class="login-form__label">Name</label>
        <input class="login-form__input" id="name" type="text" name="name" value="<?= $room_to_edit->name ?>">
      </div>

      <div class="login-form__group">
        <label for="seats" class="login-form__label">Seats</label>
        <input class="login-form__input" id="seats" type="number" name="seats" value="<?= $room->seats ?>">
      </div>

      <div class="login-form__group login-form__group--checkboxes">
        <label class="login-form__checkbox-label">
          <input
          type="checkbox"
          name="has_tv"
          class="login-form__checkbox"
          <?= $room->has_tv ? 'checked' : '' ?>
          >Has TV
        </label>

        <label class="login-form__checkbox-label">
          <input
          type="checkbox"
          name="has_audio"
          class="login-form__checkbox"
          <?= $room->has_audio ? 'checked' : '' ?>
          >Has Audio
        </label>
      </div>

      <button type="submit" class="login-form__button" name="edit_room">Update Room</button>
  </form>
</div>


<?php require_once __DIR__.'/includes/footer.php'; ?>
