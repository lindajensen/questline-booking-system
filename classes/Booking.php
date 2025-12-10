<?php
class Booking {
  public int $id;
  public int $room_id;
  public int $user_id;
  public string $date;
  public string $time;

  public function __construct(int $id, int $room_id, int $user_id, string $date, string $time) {
    $this->id = $id;
    $this->room_id = $room_id;
    $this->user_id = $user_id;
    $this->date = $date;
    $this->time = $time;
  }
}
