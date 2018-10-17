<?php
class Feedback {
  private $db;

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function fetchAllFeedbacks($userId) {
    return $this->db->fetchAllFeedbacks($userId);
  }

  public function fetchOneFeedback($id, $userId) {
    if (isset($id)) {
      return $this->db->fetchOneFeedback($id, $userId);
    } else {
      return -1;
    }
  }

  public function insertFeedback($parameters) {
    if (isset($parameters->fromUserId) && isset($parameters->toUserId) && isset($parameters->message)) {
      $this->db->insertFeedback($parameters->fromUserId, $parameters->toUserId, $parameters->message);
      return $parameters;
    } else {
      return -1;
    }
  }

  public function updateFeedback($parameters) {
    if (isset($parameters['message']) && isset($parameters['id'])) {
      $this->db->updateFeedback($parameters['message'], $parameters['id']);
      return $parameters;
    } else {
      return -1;
    }
  }

  public function deleteFeedback($id) {
    if (isset($parameters->id)) {
      $this->db->deleteFeedback($parameters->id);
      return [
        "message" => "Feedback with the id $id was successfully deleted",
      ];
    } else {
      return -1;
    }
  }

}
