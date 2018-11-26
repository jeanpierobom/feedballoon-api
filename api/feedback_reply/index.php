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
if ($authResult['id'] > 0) {
  $userId = $authResult['id'];
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
  case "POST":
    $replyReceived = json_decode(file_get_contents("php://input"));
    if (!isset($replyReceived)) {
      $replyReceived = json_decode($_POST["body"]);
    }
    $results = $feedback->insertFeedbackReply($replyReceived);
    $resultsInfo = $db->executeCall($username, 1000, 86400);
    if ($results === -1) {
      $http->badRequest($replyReceived . "A valid JSON of fields is required");
    }else if($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $results);
    }
    break;
}
