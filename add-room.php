<!-- Add Room -->
<?php
  session_start();

  $pageTitle = 'Questline Bookings | Create Room';
  $error = '';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/Room.php';

  // Handle new room submission
  if (isset($_POST['add_room'])) {
    $name = trim($_POST['name']);
    $seats = (int)($_POST['seats'] ?? 0);

    // Validate input
    if ($name === '') {
      $error = "Room name cannot be empty.";
    } elseif ($seats <= 0) {
      $error = "Seats must be a positive number.";
    } else {
      $rooms = loadRooms('data/rooms.json');

      $duplicate_room = false;

      // Check if room exists
      foreach ($rooms as $room) {
        if (strcasecmp($room->name, $name) === 0) {
          $duplicate_room = true;
          break;
        }
      }

      if ($duplicate_room) {
        $error = "Room with this name already exists.";
      } else {
        // Create new room
        $new_room = new Room(
          getNextId($rooms),
          $name,
          $seats,
          isset($_POST['has_tv']),
          isset($_POST['has_audio'])
        );

        $rooms[] = $new_room;

        saveRooms('data/rooms.json', $rooms);

        header('Location: rooms.php');
        exit;
      }
    }
  }

  require_once __DIR__. '/includes/header.php';
?>

<div class="login-form">
  <h1 class="login-form__title">Create New Room</h1>

  <?php if ($error): ?><p class="login-form__error" role="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form class="login-form__form" method="POST">
    <div class="login-form__group">
      <label for="name" class="login-form__label">Name</label>
      <input class="login-form__input" id="name" type="text" name="name">
      </div>

      <div class="login-form__group">
        <label for="seats" class="login-form__label">Seats</label>
        <input class="login-form__input" id="seats" type="number" name="seats">
      </div>

      <div class="login-form__group login-form__group--checkboxes">
        <label class="login-form__checkbox-label">
          <input
          aria-label="Has TV"
          type="checkbox"
          name="has_tv"
          class="login-form__checkbox">Has TV
        </label>

        <label class="login-form__checkbox-label">
          <input
          aria-label="Has Audio"
          type="checkbox"
          name="has_audio"
          class="login-form__checkbox">Has Audio
        </label>
      </div>

      <button type="submit" class="login-form__button" name="add_room">Add Room</button>
  </form>
</div>

<?php require_once __DIR__.'/includes/footer.php'; ?>
