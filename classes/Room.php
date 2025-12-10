<?php
class Room {
  public int $id;
  public string $name;
  public int $seats;
  public bool $has_tv;
  public bool $has_audio;

  public function __construct(int $id, string $name, int $seats, bool $has_tv, bool $has_audio) {
    $this->id = $id;
    $this->name = $name;
    $this->seats = $seats;
    $this->has_tv = $has_tv;
    $this->has_audio = $has_audio;
  }
}
