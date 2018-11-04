<?php
class User {
  private $db;

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function insertUser($parameters) {
    if (isset($parameters->firstName) && isset($parameters->lastName) && isset($parameters->password)) {
      $firstName = $parameters->firstName;
      $lastName = $parameters->lastName;
      $username =  $parameters->username;
      $password = $parameters->password;
      $this->db->insertUser($firstName, $lastName, $username, $password);
      return [
        "firstName" => $firstName,
        "lastName" => $lastName,
        "username" => $username
      ];
    }else {
      return -1;
    }
  }

  public function fetchAllUsers() {
      $query = "SELECT users.id, users.username FROM users ORDER BY users.username";
      return $this->db->fetchAll($query);
  }

  public function fetchOneUser($parameter) {
      $query = "SELECT users.id, users.username FROM users WHERE users.id = ?";
      return $this->db->fetchOne($query, $parameter);
  }

  public function fetchUsersByNameOrEmail($parameter) {
      return $this->db->fetchUsersByNameOrEmail($parameter);
  }

}
