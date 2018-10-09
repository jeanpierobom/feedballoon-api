<?php
class Group {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

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

}