<?php
class Reply {
  private $db;

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function fetchAllRepliesByFeedback($feedbackId) {
    return $this->db->fetchAllRepliesByFeedback($userId);
  }

  public function fetchOneReply($id) {
    if (isset($id)) {
      return $this->db->fetchOneReply($id);
    } else {
      return -1;
    }
  }

  public function insertReply($parameters) {
    if (isset($parameters->feedbackId) && isset($parameters->userId) && isset($parameters->message)) {
      $this->db->insertReply($parameters->feedBackId, $parameters->userId, $parameters->message);
      return $parameters;
    } else {
      return -1;
    }
  }

  public function updateReply($parameters) {
    if (isset($parameters['message']) && isset($parameters['id'])) {
      $this->db->updateReply($parameters['message'], $parameters['id']);
      return $parameters;
    } else {
      return -1;
    }
  }

}
