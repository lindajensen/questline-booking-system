<!-- List rooms, add rooms, and edit rooms -->

<?php
  session_start();

  $pageTitle = 'Questline Bookings | Manage Rooms';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/Room.php';
  require_once __DIR__.'/classes/Booking.php';
  require_once __DIR__.'/classes/User.php';

  // Handle room deletion
  if (isset($_POST['delete_room'])) {
    $id = (int)($_POST['room_id'] ?? 0);

    $rooms = loadRooms('data/rooms.json');

    // Find and delete selected room
    $updated_rooms = array_values(
      array_filter($rooms, fn($room) => $room->id !== $id)
    );

    saveRooms('data/rooms.json', $updated_rooms);

    header('Location: rooms.php');
    exit;
  }

  // Load data for rendering
  $rooms = loadRooms('data/rooms.json');
  $bookings = loadBookings('data/bookings.json');
  $users = loadUsers('data/users.json');

  require_once __DIR__. '/includes/header.php';

?>

<section class="rooms__actions">
  <h1 class="rooms__heading">Rooms</h1>
  <a href="add-room.php" class="rooms__button rooms__button--primary">
    <i data-lucide="plus" aria-hidden="true"></i> Add Room
  </a>
</section>

<section class="rooms">
  <?php foreach($rooms as $room): ?>
    <article class="room-card">
      <header class="room-card__header">
        <div>
          <h3 class="room-card__title"><?= htmlspecialchars($room->name) ?></h3>
          <p class="room-card__id">Room #<?= $room->id ?></p>
        </div>
      </header>

      <div class="room-card__features">
        <div class="room-card__feature">
          <i data-lucide="users" aria-hidden="true"></i>
        <span><?= $room->seats ?> seats</span>
        </div>

        <div class="room-card__feature <?= $room->has_tv ? '' : 'room-card__feature--disabled' ?>">
          <i data-lucide="tv" aria-hidden="true"></i>
          <span><?= $room->has_tv ? 'TV' : 'No TV' ?></span>
        </div>

        <div class="room-card__feature <?= $room->has_audio ? '' : 'room-card__feature--disabled' ?>">
          <i data-lucide="volume-2" aria-hidden="true"></i>
          <span><?= $room->has_audio ? 'Audio' : 'No Audio' ?></span>
        </div>
      </div>

      <?php
      $room_bookings = getRoomBookings($room->id, $bookings);
      if (!empty($room_bookings)): ?>
      <div class="room-card__bookings">
        <h4 class="room-card__bookings-title">Upcoming Bookings</h4>
        <ul class="room-card__bookings-list">
          <?php foreach($room_bookings as $booking): ?>
            <li class="room-card__booking">
              <i data-lucide="calendar" aria-hidden="true"></i>
              <span><?= $booking->date ?> <?= $booking->time ?></span>
              <span class="room-card__booking-user">Booked by @<?= getUserName($booking->user_id, $users) ?></span>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php else: ?>
          <div class="room-card__bookings">
            <p class="room-card__bookings-empty">No bookings yet</p>
          </div>
          <?php endif; ?>

      <footer class="room-card__actions">
        <form action="room-booking.php" method="GET">
          <input type="hidden" name="id" value="<?= $room->id ?>">
          <button class="room-card__button room-card__button--primary">
            <i data-lucide="calendar-plus"></i>Book
          </button>
        </form>

        <form action="edit-room.php" method="GET">
          <input type="hidden" name="id" value="<?= $room->id ?>">
          <button type="submit" class="room-card__button room-card__button--secondary">
            <i data-lucide="pencil"></i>Edit
          </button>
        </form>

        <form method="POST" onsubmit="return confirm('Delete room <?= $room->name ?>? This will also delete all bookings for this room.')">
          <input type="hidden" name="room_id" value="<?= $room->id ?>">
          <button type="submit" name="delete_room" class="room-card__button room-card__button--danger" aria-label="Delete room <?= htmlspecialchars($room->name) ?>">
            <i data-lucide="trash-2" aria-hidden="true"></i>
          </button>
        </form>
      </footer>
    </article>
  <?php endforeach; ?>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>

<!-- https://www.php.net/manual/en/function.usort.php -->
