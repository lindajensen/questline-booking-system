<!-- List, add, and edit users -->
<?php
  session_start();

  $pageTitle = 'Questline Bookings | Manage Users';

  require_once __DIR__. '/includes/check-login.php';
  require_once __DIR__.'/includes/functions.php';
  require_once __DIR__.'/classes/User.php';
  require_once __DIR__.'/classes/Booking.php';

  $users = loadUsers('data/users.json');
  $bookings = loadBookings('data/bookings.json');

  // Handle user deletion
  if (isset($_POST['delete_user'])) {
    $id = (int)($_POST['user_id'] ?? 0);

    $users = loadUsers('data/users.json');

    // Find and delete selected user
    $updated_users = array_values(
      array_filter($users, fn($user) => $user->id !== $id)
    );

    saveUsers('data/users.json', $updated_users);

    $bookings = loadBookings('data/bookings.json');

    // Delete all bookings belonging to this user
    $updated_bookings = array_values(
      array_filter($bookings, fn($booking) => $booking->user_id !== $id)
    );

    saveBookings('data/bookings.json', $updated_bookings);

    header('Location: users.php');
    exit;
  }

  require_once __DIR__. '/includes/header.php';
?>

<section class="users">
  <header class="users__header">
    <h1 class="users__heading">Manage Users</h1>

    <a href="add-user.php" class="users__button">
      <i data-lucide="user-plus" aria-hidden="true"></i>
      Add User
    </a>
  </header>

  <div class="users__list">
  <?php foreach($users as $user): ?>
    <div class="user-card">
      <div class="user-card__header">
        <div class="user-card__avatar" aria-hidden="true">
          <?= strtoupper(substr($user->name, 0, 1)) ?>
        </div>
        <div class="user-card__info">
          <h3 class="user-card__name"><?= htmlspecialchars($user->name) ?></h3>
          <p class="user-card__username">@<?= htmlspecialchars($user->username) ?></p>
        </div>
      </div>

      <div class="user-card__stats">
        <div class="user-card__stat">
          <i data-lucide="calendar-check"></i>
          <span><?= countUserBookings($user->id, $bookings) ?> bookings</span>
        </div>
      </div>

      <div class="user-card__actions">
        <form action="edit-user.php" method="GET">
          <input type="hidden" name="id" value="<?= $user->id ?>">
          <button class="user-card__button user-card__button--secondary" type="submit">
            <i data-lucide="pencil" aria-hidden="true"></i>
              Edit
          </button>
        </form>

        <form method="POST" onsubmit="return confirm('Delete <?= $user->name ?>? This will also delete all their bookings.')">
          <input type="hidden" name="user_id" value="<?= $user->id ?>">

          <button type="submit" name="delete_user" class="user-card__button user-card__button--danger" aria-label="Delete <?= htmlspecialchars($user->name) ?>">
          <i data-lucide="trash-2" aria-hidden="true"></i>
        </button>
        </form>
      </div>
    </div>

    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
