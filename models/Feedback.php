<?php
class Feedback {
  private $db;

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function fetchAllFeedbacks($userId) {
    $newResult = array();
    $resultList = $this->db->fetchAllFeedbacks($userId);
    foreach ($resultList as $currentFeedback) {
      $currentFeedback["user_from_initials"] = $currentFeedback["user_from_firstname"][0] . $currentFeedback["user_from_lastname"][0];
      $currentFeedback["user_to_initials"] = $currentFeedback["user_to_firstname"][0] . $currentFeedback["user_to_lastname"][0];
      $currentFeedback["type"] = $currentFeedback["from_user_id"] == $userId ? "sent" : "received";
      array_push($newResult, $currentFeedback);
    }
    return $newResult;
  }

  public function fetchOneFeedback($id, $userId) {
    if (isset($id)) {
      $resultFeedback = $this->db->fetchOneFeedback($id, $userId);
      $resultFeedback["user_from_initials"] = $resultFeedback["user_from_firstname"][0] . $resultFeedback["user_from_lastname"][0];
      $resultFeedback["user_to_initials"] = $resultFeedback["user_to_firstname"][0] . $resultFeedback["user_to_lastname"][0];
      $resultFeedback["type"] = $resultFeedback["from_user_id"] == $userId ? "sent" : "received";

      $repliesList = $this->db->fetchAllFeedbackReplies($id);
      $resultFeedback["replies"] = $repliesList;

      return $resultFeedback;
    } else {
      return -1;
    }
  }

  public function insertFeedback($parameters) {
    if (isset($parameters->fromUserId) && isset($parameters->toUserId) && isset($parameters->tag) && isset($parameters->message)) {
      $this->db->insertFeedback($parameters->fromUserId, $parameters->toUserId, $parameters->tag, $parameters->message);
      return $parameters;
    } else {
      return -1;
    }
  }

  public function insertFeedbackReply($parameters) {
    if (isset($parameters->feedbackId) && isset($parameters->userId) && isset($parameters->message)) {
      $this->db->insertFeedbackReply($parameters->feedbackId, $parameters->userId, $parameters->message);
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

  public function fetchAllFeedbackReplies($feedbackId) {
    $resultList = $this->db->fetchAllFeedbackReplies($feedbackId);
    return $resultList;
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
