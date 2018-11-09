<?php
header('Content-Type: application/json');

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400'); // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

  exit(0);
}

require_once "../../config/Database.php";
require_once "../../models/Feedback.php";
require_once "../../models/HttpResponse.php";
require_once "../../models/Authenticate.php";

$db = new Database();
$feedback = new Feedback($db);
$auth = new Authenticate($db);
$http = new HttpResponse();

// Authenticate the user
$userId = 0;
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
$authResult = $auth->authenticate($username, $password);

// Validate the authentication results
if ($authResult > 0) {
  $userId = $authResult;
} else { // Invalid authentication
  switch ($authResult) {
    case -1:
      $http->notAuthorized("You must authenticate yourself before you can use our REST API services");
      break;
    case -2:
      $http->notAuthorized("You provided wrong credentials");
      break;
  }
  exit();
}

switch ($_SERVER['REQUEST_METHOD']) {
  case "GET":

    // Filter by id
    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
      $http->badRequest("Only a valid integer is allowed to fetch a single feedback");
      die();
    }

    // Fetch one feedback by ID, or all if there is no ID
    $resultsData = isset($_GET['id']) ? $feedback->fetchOneFeedback($_GET['id'], $userId) : $feedback->fetchAllFeedbacks($userId);
    $resultsInfo = $db->executeCall($username, 1000, 86400);
    if ($resultsData === 0) {
      $message = "No feedback ";
      $message .= isset($_GET['id']) ? "with the id " . $_GET['id'] : "";
      $message .= " was found";
      $http->notFound($message);
    } else if ($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $resultsData);
    }
    break;

  case "POST":

    $feedbackReceived = json_decode(file_get_contents("php://input"));
    $results = $feedback->insertFeedback($feedbackReceived);
    $resultsInfo = $db->executeCall($username, 1000, 86400);
    if ($results === -1) {
      $http->badRequest("A valid JSON of fields is required");
    }else if($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $results);
    }
    break;

  case "PUT":

    $feedbackReceived = json_decode(file_get_contents("php://input"));
    if ($feedbackReceived->id <= 0) {
      $http->badRequest("Please an id is required to make a PUT request");
      exit();
    }
    $results = $db->fetchOneFeedback($feedbackReceived->id);
    if ($results === 0) {
      $http->notFound("Feedback with the id $feedbackReceived->id was not found");
    } else if($results['from_user_id'] !== $userId) {
      $http->notAuthorized("You are not authorized to update this feedback (" . $results['from_user_id'] . ":" . $userId . ")");
    } else {
      $parameters = [
        'id' => $feedbackReceived->id,
        'message' => isset($feedbackReceived->message) ? $feedbackReceived->message : $results['message'],
      ];

      $resultsData = $feedback->updateFeedback($parameters);
      $resultsInfo = $db->executeCall($username, 1000, 86400);

      if ($resultsInfo === -1)  {
        $http->paymentRequired();
      }else {
        $http->OK($resultsInfo, $resultsData);
      }
    }

    break;
  case "DELETE":

    $parameters = json_decode(file_get_contents("php://input"));
    if (!$parameters->id) {
      $http->badRequest("No id was provided");
      exit();
    }

    $results = $db->fetchOneFeedback($parameters->id);
    if ($results === 0) {
      $http->notFound("Feedback with the id $parameters->id was not found");
      exit();
    }
    if ($results['user_id'] !== $userId) {
      $http->notAuthorized("You are not authorized to delete this feedback");
    }else {
      $resultsData = $user->deleteFeedback($parameters->id);
      $resultsInfo = $db->executeCall($username, 1000, 86400);

      if ($resultsInfo === -1) {
        $http->paymentRequired();
      }else {
        $http->OK($resultsInfo, $resultsData);
      }
    }

    break;
}
