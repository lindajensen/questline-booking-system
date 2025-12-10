<?php
// Read and parse JSON file
function readJSON (string $file): array {
  if (!file_exists($file)) return [];

  $json = file_get_contents($file);

  $data = json_decode($json, true);

  return $data;
}

// Write data to JSON file
function writeJSON(string $file, array $data): void {
  $json = json_encode($data, JSON_PRETTY_PRINT);

  file_put_contents($file, $json);
}

// Generate next available ID from an array of objects
function getNextId(array $array): int {
  if (empty($array)) {
      return 1;
  }

  $ids = array_column($array, 'id');
  return max($ids) + 1;
}

// Hash password using PHP's password_hash
function hashPassword(string $password): string {
  return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password against the hashed password
function verifyPassword(string $password, string $hash): bool {
  if (password_verify($password, $hash)) {
      return true;
  } else {
      return false;
  }
}

// Extract first name from full name
function getFirstName(string $name): string {
  return explode(' ', $name)[0];
}


// Sort bookings chronologically by date and time
function sortBookingsChronologically(array $bookings): array {
  usort($bookings, function($a, $b) {
    $timeA = strtotime($a->date . ' ' . $a->time);
    $timeB = strtotime($b->date . ' ' . $b->time);

    return $timeA <=> $timeB;
  });
  return $bookings;
}

// Count total bookings for a specific user
function countUserBookings(int $user_id, array $bookings): int {
  $count = 0;
  foreach($bookings as $booking) {
      if ($booking->user_id === $user_id) {
          $count++;
      }
  }
  return $count;
}


// Get all bookings for a specific room, sorted chronologically
function getRoomBookings(int $room_id, array $bookings): array {
  $room_bookings = [];

  foreach($bookings as $booking) {
      if ($booking->room_id === $room_id) {
          $room_bookings[] = $booking;
      }
  }
  return sortBookingsChronologically($room_bookings);
}

// Get username by user ID
function getUserName(int $user_id, array $users): string {
  foreach($users as $user) {
      if ($user->id === $user_id) {
          return $user->username;
      }
  }
  return 'Unknown';
}

// Get room name by ID
function getRoomName(int $room_id, array $rooms): string {
  foreach($rooms as $room) {
    if ($room->id === $room_id) {
      return $room->name;
    }
  }
  return 'Unknown Room';
}

// Loads all users from JSON file and returns them as User objects
function loadUsers(string $file): array {
  $data = readJSON($file);
  $users = [];

  foreach($data as $d) {
    $users[] = new User($d['id'], $d['name'], $d['username'], $d['passwordHash']);
  }
  return $users;
}

// Saves an array of user objects to a JSON file.
function saveUsers(string $file, array $users): void {
  $data = [];

  foreach($users as $u) {
    $data[] = [
      'id' => $u->id,
      'name' => $u->name,
      'username' => $u->username,
      'passwordHash' => $u->passwordHash
    ];
  }
  writeJSON($file, $data);
}

// Loads all bookings from JSON file and returns them as Booking objects
function loadBookings(string $file): array {
  $data = readJSON($file);
  $bookings = [];

  foreach($data as $d) {
    $bookings[] = new Booking($d['id'], $d['room_id'],
    $d['user_id'], $d['date'], $d['time']);
  }
  return $bookings;
}

// Saves an array of booking objects to a JSON file.
function saveBookings(string $file, array $bookings): void {
  $data = [];
  foreach($bookings as $b) {
      $data[] = [
          'id' => $b->id,
          'room_id' => $b->room_id,
          'user_id' => $b->user_id,
          'date' => $b->date,
          'time' => $b->time
      ];
  }
  writeJSON($file, $data);
}

// Loads all rooms from JSON file and returns them as Room objects
function loadRooms(string $file): array {
  $data = readJSON($file);
  $rooms = [];

  foreach($data as $d) {
      $rooms[] = new Room($d['id'], $d['name'], $d['seats'], $d['has_tv'], $d['has_audio']);
  }
  return $rooms;
}

// Saves an array of room objects to a JSON file.
function saveRooms(string $file, array $rooms): void {
  $data = [];

  foreach($rooms as $r) {
      $data[] = [
          'id' => $r->id,
          'name' => $r->name,
          'seats' => $r->seats,
          'has_tv' => $r->has_tv,
          'has_audio' => $r->has_audio
      ];
  }
  writeJSON($file, $data);
}

// https://www.w3schools.com/php/func_math_max.asp
// https://www.php.net/manual/en/function.array-column.php
// https://www.php.net/manual/en/function.password-verify.php

// https://www.php.net/manual/en/function.strtotime.php
// https://stackoverflow.com/questions/30365346/what-is-the-spaceship-operator-in-php-7
