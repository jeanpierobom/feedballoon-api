<?php
class User {
  private $db;

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function insertUser($parameters) {
    if (isset($parameters->firstName) && isset($parameters->lastName) && isset($parameters->jobTitle) && isset($parameters->username) && isset($parameters->password)) {
      $firstName = $parameters->firstName;
      $lastName = $parameters->lastName;
      $jobTitle = $parameters->jobTitle;
      $username =  $parameters->username;
      $password = $parameters->password;
      $this->db->insertUser($firstName, $lastName, $jobTitle, $username, $password);
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

  public function fetchOneUser($id) {
    if (isset($id)) {
      $user = $this->db->fetchOneUser($id);
      return $user;
    } else {
      return -1;
    }
  }

  public function fetchUsersByNameOrEmail($parameter) {
      $newResult = array();
      $resultList = $this->db->fetchUsersByNameOrEmail($parameter);
      $str = "";
      foreach ($resultList as $currentuser) {
        // $str = $currentuser['firstName'] . " " . $currentuser['lastName'] . " (" . $currentuser['username'] . ")";
        // array_push($newResult, $str);

        $nameAsList = explode(" ", $currentuser["name"]);
        $currentuser["name_initials"] = $nameAsList[0][0];
        if (sizeof($nameAsList) > 0) {
          $currentuser["name_initials"] = $currentuser["name_initials"] . $nameAsList[sizeof($nameAsList) - 1][0];
        }
        $currentuser["name_initials"] = strtoupper($currentuser["name_initials"]);
        $currentuser["userId"] = $userId;
        array_push($newResult, $currentuser);
      }
      return $newResult;

  }

}
