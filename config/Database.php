<?php
class Database {
  // DB Parameters
  private $hostName = "localhost";
  private $dbname = "feedballoon";
  private $username = "root";
  private $password = "root";
  private $pdo;

  // Start Connection
  public function __construct() {
    $this->pdo = null;
    try {
      $this->pdo = new PDO("mysql:host=$this->hostName;dbname=$this->dbname;", $this->username, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
      echo "Error : ". $e->getMessage();
    }
  }

  public function fetchAll($query) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }
    else {
      return $stmt->fetchAll();
    }
  }

  public function fetchOne($query, $parameter) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$parameter]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }else {
      return $stmt->fetch();
    }
  }

  public function executeCall($username, $calls_allowed, $timeOutSeconds) {
    $query = "SELECT plan, calls_made, time_start, time_end
              FROM users
              WHERE username = '$username'
      ";
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([$username]);
      $results = $stmt->fetch();

      // VARIABLES NEEDED
      // IF IT IS TIMEOUT OR EQUAL TO ZERO SET TO TRUE
      $timeOut = date(time()) - $results['time_start'] >= $timeOutSeconds || $results['time_start'] === 0;

      // UPDATE CALLS MADE WITH RESPECE TO TIME OUT
      $query = "UPDATE users
      SET calls_made = ";
      $query .= $timeOut ? " 1, time_start = ".date(time()). " , time_end = ". strtotime("+ $timeOutSeconds seconds") : " calls_made + 1";
      $query .= " WHERE username = ? ";

      // INSTEAD OF FETCHING AGAIN USING SELECT ALL UPDATE VARIABLES
      $results['calls_made'] = $timeOut ? 1 : $results['calls_made'] + 1;
      $results['time_end'] = $timeOut ? strtotime("+ $timeOutSeconds seconds") : $results['time_end'];

      // EXECUTE CODE WITH RESPECT TO PLANS
      if ($results['plan'] === "unlimited") {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$username]);
        return $results;
      }else {
        // IF NO TIME OUT AND CALLS MADE IS GREATER THAN CALLS ALLOWED RETURN -1
        if ($timeOut === false && $results['calls_made'] >= $calls_allowed) {
          return -1;
        }else {
          // GRANT ACCESS
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([$username]);
          return $results;
        }
      }
  }
  public function insertOne($query, $body, $user_id, $category_id, $date) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$body, $user_id, $category_id, $date]);
  }
  // public function insertOneGroup($query, $name, $private) {
  //   $stmt = $this->pdo->prepare($query);
  //   $stmt->execute([$name, $private]);
  // }
  public function updateOne($query, $body, $category_id, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$body, $category_id, $id]);
  }
  public function deleteOne($query, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
  }
  public function insertUser($firstName, $lastName, $jobTitle, $username, $password) {
    $query = "INSERT INTO users (firstName, lastName, job_title, username, password, plan, calls_made, time_start, time_end) VALUES (?, ?, ?, ?, ?, 'unlimited', 0, 0, 0)";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$firstName, $lastName, $jobTitle, $username, md5($password)]);
  }

  //---------------------------------
  public function fetchOneUserByUsername($username) {
    $query = "SELECT * FROM users WHERE username = ?";
    return $this->fetchOne($query, $username);
  }


  //----------------------------------------------------------------------------
  // Feedback methods
  //----------------------------------------------------------------------------
  public function fetchAllFeedbacks($userId) {
    $query  = "SELECT ";
    $query .= "  f.id, ";
    $query .= "  f.from_user_id, ";
    $query .= "  user_from.firstname AS user_from_firstname, ";
    $query .= "  user_from.lastname AS user_from_lastname, ";
    $query .= "  CONCAT(user_from.firstname, ' ', user_from.lastname) AS user_from_name, ";
    $query .= "  user_from.job_title AS user_from_job_title, ";
    $query .= "  f.to_user_id, ";
    $query .= "  user_to.firstname AS user_to_firstname, ";
    $query .= "  user_to.lastname AS user_to_lastname, ";
    $query .= "  CONCAT(user_to.firstname, ' ', user_to.lastname) AS user_to_name, ";
    $query .= "  user_to.job_title AS user_to_job_title, ";
    $query .= "  f.tag, ";
    $query .= "  f.message, ";
    $query .= "  f.date ";
    $query .= "FROM feedback AS f ";
    $query .= "INNER JOIN users AS user_from ON user_from.id = f.from_user_id ";
    $query .= "INNER JOIN users AS user_to ON user_to.id = f.to_user_id ";
    $query .= "WHERE (f.from_user_id = ? OR f.to_user_id = ?) ";
    $query .= "ORDER BY date DESC ";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId, $userId]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }
    else {
      return $stmt->fetchAll();
    }
  }

  public function fetchOneFeedback($id, $userId) {
    $query  = "SELECT ";
    $query .= "  f.id, ";
    $query .= "  f.from_user_id, ";
    $query .= "  user_from.firstname AS user_from_firstname, ";
    $query .= "  user_from.lastname AS user_from_lastname, ";
    $query .= "  CONCAT(user_from.firstname, ' ', user_from.lastname) AS user_from_name, ";
    $query .= "  user_from.job_title AS user_from_job_title, ";
    $query .= "  f.to_user_id, ";
    $query .= "  user_to.firstname AS user_to_firstname, ";
    $query .= "  user_to.lastname AS user_to_lastname, ";
    $query .= "  CONCAT(user_to.firstname, ' ', user_to.lastname) AS user_to_name, ";
    $query .= "  user_to.job_title AS user_to_job_title, ";
    $query .= "  f.tag, ";
    $query .= "  f.message, ";
    $query .= "  f.date ";
    $query .= "FROM feedback AS f ";
    $query .= "INNER JOIN users AS user_from ON user_from.id = f.from_user_id ";
    $query .= "INNER JOIN users AS user_to ON user_to.id = f.to_user_id ";
    $query .= "WHERE f.id = ? AND (f.from_user_id = ? OR f.to_user_id = ?) ";
    $query .= "ORDER BY date DESC ";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id, $userId, $userId]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }else {
      return $stmt->fetch();
    }
  }

  public function insertFeedback($fromUserId, $toUserId, $tag, $message) {
    $query = "INSERT INTO feedback (from_user_id, to_user_id, tag, message, date) VALUES (?, ?, ?, ?, now())";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$fromUserId, $toUserId, $tag, $message]);
  }

  public function updateFeedback($message, $id) {
    $query = "UPDATE feedback SET message = ? WHERE id = ?";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$message, $id]);
  }

  public function deleteFeedback($id) {
    $query = "DELETE FROM feedback WHERE id = ?";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
  }

  //----------------------------------------------------------------------------
  // Group methods
  //----------------------------------------------------------------------------
  public function fetchAllGroups($userId) {
    $query  = "SELECT ";
    $query .= "  g.id, ";
    $query .= "  g.name, ";
    $query .= "  g.description, ";
    $query .= "  g.private, ";
    $query .= "  (SELECT COUNT(*) FROM groups_members AS gm WHERE gm.group_id = g.id AND gm.approved) AS members_count, ";
    $query .= "  (SELECT COUNT(*) FROM groups_members AS gm_me WHERE gm_me.group_id = g.id AND gm_me.approved AND gm_me.user_id = ?) AS current_member ";
    $query .= "FROM groups AS g ";
    $query .= "ORDER BY g.name ";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }
    else {
      return $stmt->fetchAll();
    }
  }

  public function fetchAllGroupsByUser($userId) {
    return $this->fetchAllGroups($userId);
  }

  public function fetchGroupsByName($name) {
    $query  = "SELECT id, name, description, private FROM groups WHERE name LIKE ? ORDER BY name";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(["%".$name."%"]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    } else {
      return $stmt->fetchAll();
    }
  }

  public function fetchOneGroup($id) {
    $query  = "SELECT ";
    $query .= "  g.id, ";
    $query .= "  g.name, ";
    $query .= "  g.description, ";
    $query .= "  g.private, ";
    $query .= "  (SELECT COUNT(*) FROM groups_members AS gm WHERE gm.group_id = g.id AND gm.approved) AS members_count ";
    $query .= "FROM groups AS g ";
    $query .= "WHERE g.id = ? ";
    $query .= "ORDER BY g.name ";
    return $this->fetchOne($query, $id);
  }

  public function fetchAllGroupMembers($groupId) {
    $query  = "SELECT ";
    $query .= "  u.id, ";
    $query .= "  u.firstname, ";
    $query .= "  u.lastname, ";
    $query .= "  CONCAT(u.firstname, ' ', u.lastname) AS name, ";
    $query .= "  u.job_title ";
    $query .= "FROM groups_members AS gm ";
    $query .= "INNER JOIN users AS u ON u.id = gm.user_id ";
    $query .= "WHERE gm.group_id = ? ";
    $query .= "ORDER BY name ";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$groupId]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }
    else {
      return $stmt->fetchAll();
    }
  }

  public function insertGroup($name, $description, $private) {
    $query = "INSERT INTO groups (name, description, private) VALUES (?, ?, ?)";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$name, $description, $private]);
  }

  public function updateGroup($name, $description, $private, $id) {
    $query = "UPDATE groups SET name = ?, description = ?, private = ? WHERE id = ?";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$name, $description, $private, $id]);
  }

  public function insertGroupMember($groupId, $userId, $approved) {
    $query = "INSERT INTO groups_members (group_id, user_id, approved) VALUES (?, ?, ?)";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$groupId, $userId, $approved]);
  }

  public function updateGroupMember($groupId, $userId, $approved) {
    $query = "UPDATE groups_members SET approved = ? WHERE group_id = ? AND user_id = ?";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$approved, $groupId, $userId]);
  }

  //----------------------------------------------------------------------------
  // Reply methods
  //----------------------------------------------------------------------------
  public function fetchAllRepliesByFeedback($feedbackId) {
    $query  = "SELECT id, feedback_id, user_id, message, date FROM feedback_reply WHERE feedback_id = ? ORDER BY date";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$feedbackId]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    } else {
      return $stmt->fetchAll();
    }
  }

  public function fetchOneReply($id) {
    $query  = "SELECT id, feedback_id, user_id, message, date FROM feedback_reply WHERE id = ?";
    return $this->fetchOne($query, $id);
  }

  public function insertReply($feedbackId, $userId, $message) {
    $query = "INSERT INTO feedback_reply (feedback_id, user_id, message, date) VALUES (?, ?, ?, now())";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$feedbackId, $userId, $message]);
  }

  public function updateReply($message, $id) {
    $query = "UPDATE feedback_reply SET message = ? WHERE id = ?";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$message, $id]);
  }

  //----------------------------------------------------------------------------
  // User methods
  //----------------------------------------------------------------------------
  public function fetchUsersByNameOrEmail($argument) {
    $query = "SELECT users.id, users.username, users.firstname, users.lastname FROM users WHERE users.username LIKE ? OR CONCAT(users.firstname, ' ', users.lastname) LIKE ? ";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(["%".$argument."%", "%".$argument."%"]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    } else {
      return $stmt->fetchAll();
    }
  }

}
