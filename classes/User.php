<?php
class User {
  public int $id;
  public string $name;
  public string $username;
  public string $passwordHash;


  public function __construct(int $id, string $name, string $username, string $passwordHash) {
    $this->id = $id;
    $this->name = $name;
    $this->username = $username;
    $this->passwordHash = $passwordHash;
  }
}
