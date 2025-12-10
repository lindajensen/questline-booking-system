<!-- Dashboard (Home) - My bookings when logged in -->
<?php
  session_start();

  $pageTitle = 'Questline Bookings | Dashboard';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/Room.php';
  require_once __DIR__.'/classes/Booking.php';

  // Handle deletion of booking
  if (isset($_POST['delete_booking'])) {
    $id = (int)($_POST['booking_id'] ?? 0);

    $bookings = loadBookings('data/bookings.json');

    $updated_bookings = array_values(
      array_filter($bookings, fn($booking) => $booking->id !== $id)
    );

    saveBookings('data/bookings.json', $updated_bookings);

    header('Location: dashboard.php');
    exit;
  }

  $my_bookings = [];

  $bookings = loadBookings('data/bookings.json');
  $rooms = loadRooms('data/rooms.json');

  // Find bookings belonging to logged in user
  foreach($bookings as $booking) {
    if ($booking->user_id === $_SESSION['user_id']) {
      $my_bookings[] = $booking;
    }
  }

  $my_bookings = sortBookingsChronologically($my_bookings);

  require_once __DIR__. '/includes/header.php';
?>

<div class="dashboard">
  <aside class="dashboard__sidebar">
    <div class="dashboard__user">
      <div class="dashboard__avatar">
        <?= htmlspecialchars(strtoupper(substr($_SESSION['name'], 0, 1))) ?>
      </div>
      <p class="dashboard__username"><?= htmlspecialchars($_SESSION['name']) ?></p>
    </div>

    <ul class="dashboard__quick-actions">
      <li class="dashboard__quick-action">
        <a href="room-booking.php" class="dashboard__quick-link">
          <i data-lucide="plus" aria-hidden="true"></i>
            New Booking
        </a>
      </li>

      <li class="dashboard__quick-action">
        <a href="rooms.php" class="dashboard__quick-link">
          <i data-lucide="door-closed" aria-hidden="true"></i>
            View Rooms
        </a>
      </li>

      <li class="dashboard__quick-action">
        <a href="users.php" class="dashboard__quick-link">
          <i data-lucide="user-pen" aria-hidden="true"></i>
            Manage Users
        </a>
      </li>
    </ul>
  </aside>

  <section class="dashboard__main">
    <h1 class="dashboard__title">My Bookings</h1>

    <?php if (empty($my_bookings)): ?>
      <div class="dashboard__empty">
        <i data-lucide="calendar-x" class="dashboard__empty-icon"></i>
        <p class="dashboard__empty-text">You don't have any bookings yet.</p>
        <p class="dashboard__empty-hint">Click "New Booking" to get started!</p>
      </div>

    <?php else: ?>
      <div class="dashboard__bookings">
        <?php foreach($my_bookings as $booking): ?>
          <div class="booking-card">
            <header class="booking-card__header">
              <div class="booking-card__left">
                <span class="booking-card__date-badge">
                  <i data-lucide="calendar"></i> <?= $booking->date ?>
                </span>
                <h3 class="booking-card__room"><?= htmlspecialchars(getRoomName($booking->room_id, $rooms)) ?></h3>
              </div>

              <form method="POST" onsubmit="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                <input type="hidden" name="booking_id" value="<?= $booking->id ?>">
                <button type="submit" name="delete_booking" class="booking-card__delete" aria-label="Delete booking">
                  <i data-lucide="trash-2" aria-hidden="true"></i>
                </button>
              </form>
            </header>

            <div class="booking-card__details">
              <div class="booking-card__detail">
                <i data-lucide="clock" aria-hidden="true"></i>
                <span><?= $booking->time ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</div>

  <?php require_once __DIR__.'/includes/footer.php'; ?>
