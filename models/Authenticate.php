<?php
class Authenticate {
  private $db;

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function authenticate($username, $password) {
    if (!isset($username) && !isset($password)) {
      return -1;
    } else {
      $results = $this->db->fetchOneUserByUsername($username);
      if ($results === 0 || $results['password'] !== md5($password)) {
        return -2;
      } else {
        return $results;
      }
    }
  }
}
