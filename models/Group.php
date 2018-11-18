<?php
class Group {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchAllGroups($userId) {
      $newResult = array();
      $resultList = $this->db->fetchAllGroups($userId);
      foreach ($resultList as $currentGroup) {
        $nameAsList = explode(" ", $currentGroup["name"]);
        $currentGroup["name_initials"] = $nameAsList[0][0];
        if (sizeof($nameAsList) > 0) {
          $currentGroup["name_initials"] = $currentGroup["name_initials"] . $nameAsList[sizeof($nameAsList) - 1][0];
        }
        $currentGroup["name_initials"] = strtoupper($currentGroup["name_initials"]);
        $currentGroup["userId"] = $userId;
        array_push($newResult, $currentGroup);
      }
      return $newResult;
    }

    public function fetchAllGroupsByUser($userId) {
      return $this->db->fetchAllGroupsByUser($userId);
    }

    public function fetchGroupsByName($name) {
      return $this->db->fetchGroupsByName($name);
    }

    public function fetchOneGroup($id, $userId) {
      if (isset($id)) {
        $group = $this->db->fetchOneGroup($id, $userId);
        $nameAsList = explode(" ", $group["name"]);
        $group["name_initials"] = $nameAsList[0][0];
        if (sizeof($nameAsList) > 0) {
          $group["name_initials"] = $group["name_initials"] . $nameAsList[sizeof($nameAsList) - 1][0];
        }
        $group["name_initials"] = strtoupper($group["name_initials"]);
        return $group;
      } else {
        return -1;
      }
    }

    public function fetchAllGroupMembers($groupId) {
      $newResult = array();
      $resultList = $this->db->fetchAllGroupMembers($groupId);
      foreach ($resultList as $currentUser) {
        $nameAsList = explode(" ", $currentUser["name"]);
        $currentUser["name_initials"] = $nameAsList[0][0];
        if (sizeof($nameAsList) > 0) {
          $currentUser["name_initials"] = $currentUser["name_initials"] . $nameAsList[sizeof($nameAsList) - 1][0];
        }
        $currentUser["name_initials"] = strtoupper($currentUser["name_initials"]);
        array_push($newResult, $currentUser);
      }

      return $newResult;
    }

    public function insertGroup($parameters, $userId) {
      if (isset($parameters->name) && isset($parameters->private)) {
        $groupId = $this->db->insertGroup($parameters->name, $parameters->description, $parameters->private);
        $this->db->insertGroupMember($groupId, $userId, true, true);
        return $parameters;
      } else {
        return -1;
      }
    }

    public function insertGroupMember($parameters) {
      if (isset($parameters->groupId) && isset($parameters->userId)) {
        $this->db->insertGroupMember($parameters->groupId, $parameters->userId, false, false);
        return $parameters;
      } else {
        return -1;
      }
    }

    public function updateGroupMember($parameters) {
      if (isset($parameters->groupId) && isset($parameters->userId)) {
        $this->db->updateGroupMember($parameters->groupId, $parameters->userId, false);
        return $parameters;
      } else {
        return -1;
      }
    }

    public function updateGroup($parameters) {
      if (isset($parameters['name']) && isset($parameters['private'])) {
        $this->db->updateGroup($parameters['name'], $parameters['private'], $parameters['id']);
        return $parameters;
      } else {
        return -1;
      }
    }

    /*
    public function fetchAllGroups() {
        $query = "SELECT id, name, private FROM groups ORDER BY name";
        return $this->db->fetchAll($query);
    }
    public function fetchOneGroup($parameter) {
        $query = "SELECT id, name, private FROM groups ORDER BY name WHERE id = ?";
        return $this->db->fetchOne($query, $parameter);
    }

    public function fetchUsersGroup($id) {
        $query = "SELECT
    group.id AS group_id, group.name AS group_name, users.id AS users_id FROM groups
    INNER JOIN group_members ON group_members.group_id = groups.id
    INNER JOIN users ON group_members.user_id = users.id
    WHERE users.id = '$id'
    ORDER BY groups.name ";
        return $this->db->fetchAll($query);
    }
    public function insertGroup($parameters, $user_id) {
        $query = "INSERT INTO groups (name, private) VALUES (?, ?)";
        if (isset($parameters->name) && isset($parameters->private)) {
            $name = $parameters->name;
            $private = $parameters->private;
            //$date = date("d/m/Y");
            $this->db->insertOneGroup($query, $name, $private);
            return $parameters;
        }else {
          return -1;
        }
    }
    public function updateGroup($parameters) {
        $query = "UPDATE group SET name = ?, private = ? WHERE id = ?";
        if (isset($parameters['id']) && isset($parameters['name']) && isset($parameters['private'])) {
            $id = $parameters['id'];
            $name = $parameters['name'];
            $private = $parameters['private'];
            $results = $this->db->updateOne($query, $name, $private, $id);
            return $parameters;
        } else {
            return -1;
        }
    }
    public function deleteGroup($id) {
        $query = "DELETE FROM groups WHERE id = ?";
        $results = $this->db->deleteOne($query, $id);
        return [
            "message" => "Group with the id $id was successfully deleted",
        ];
    }
    */
}
