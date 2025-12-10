<!-- Book a Room -->
<?php
  session_start();

  $pageTitle = 'Questline Bookings | Book a Room';
  $error = '';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/Room.php';
  require_once __DIR__.'/classes/Booking.php';

  $id = (int)($_GET['id'] ?? 0);

  $rooms = loadRooms('data/rooms.json');
  $bookings = loadBookings('data/bookings.json');

  $room_to_book = null;

  // Find room based on ID
  foreach($rooms as $room) {
    if ($room->id === $id) {
      $room_to_book = $room;
      break;
    }
  }

  if ($room_to_book === null) {
    header('Location: rooms.php');
    exit;
  }

  // Booking form submission
  if (isset($_POST['create_booking'])) {
    $room_id = (int)($_POST['room_id'] ?? 0);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $user_id = $_SESSION['user_id'];

    // Validate booking time (must be between 08:00-20:00 and on the hour)
    $hour = (int)explode(':', $time)[0];
    $minute = (int)explode(':', $time)[1];

    if ($hour < 8 || $hour > 20) {
      $error = "Bookings can only be made between 08:00 and 20:00.";
    } elseif ($minute !== 0) {
      $error = "Bookings must start on the hour.";
    }

    // Check if date is a wwekday
    $weekdayNumber = date('N', strtotime($date));

    if ($weekdayNumber >= 6) {
      $error = "Bookings cannot be made on weekends.";
    }

    if (!$error) {
      // Calculate booking time slot (2 hours)
      $start_time = strtotime("$date $time");
      $end_time = $start_time + 2 * 60 * 60;

      $room_taken = false;

      // Check if room is booked
      foreach ($bookings as $booking) {
        if ($booking->room_id === $room_id && $booking->date === $date) {
          $existing_start = strtotime("{$booking->date} {$booking->time}");
          $existing_end = $existing_start + 2 * 60 * 60;

          // Check for time overlap
          if ($start_time < $existing_end && $end_time > $existing_start) {
            $room_taken = true;
            break;
          }
        }
      }

      if ($room_taken) {
        $error = "Room is already booked at this time!";
      } else {
        // Create new booking
        $new_booking = new Booking(
          getNextId($bookings),
          $room_id,
          $user_id,
          $date,
          $time
        );

        $bookings[] = $new_booking;
        saveBookings('data/bookings.json', $bookings);

        header('Location: dashboard.php');
        exit;
      }
    }
  }

  require_once __DIR__. '/includes/header.php';
?>

<div class="login-form">
  <h1 class="login-form__title">Book Room</h1>
  <p class="login-form__subtitle">All bookings are 2 hours long</p>

  <?php if ($error): ?><p class="login-form__error" role="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form class="login-form__group" method="POST">
    <div class="login-form__group">
      <input type="hidden" name="room_id" value="<?= $room_to_book->id ?>">
    </div>

    <div class="login-form__group">
      <label class="login-form__label">Booking Room</label>
      <div class="login-form__room-display" aria-readonly="true">
        <p><?= $room_to_book->name ?></p>
      </div>
    </div>

    <div class="login-form__group">
      <label for="date" class="login-form__label">Date</label>
      <input type="date" id="date" name="date" class="login-form__input" required>
    </div>

    <div class="login-form__group">
      <label for="time" class="login-form__label">Time</label>
      <input type="time" id="time" name="time" class="login-form__input">
    </div>

    <button class="login-form__button" type="submit" name="create_booking">Confirm Booking</button>
  </form>
</div>

<?php require_once __DIR__.'/includes/footer.php'; ?>
