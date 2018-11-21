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
require_once "../../models/Group.php";
require_once "../../models/HttpResponse.php";
require_once "../../models/Authenticate.php";

$db = new Database();
$group = new Group($db);
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
  case "GET":

    // Filter by id
    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
      $http->badRequest("Only a valid integer is allowed to fetch a single group");
      die();
    }

    // Fetch one group by ID, or all if there is no ID
    if (isset($_GET['id'])) { // Filter by ID
      $resultsData = $group->fetchOneGroup($_GET['id'], $userId);
    }

    else if (isset($_GET['name'])) { // Filter by name
      $resultsData = $group->fetchGroupsByName($_GET['name'], $userId);
    }

    else { // Fetch all
      $resultsData = $group->fetchAllGroups($userId);
    }

    //$resultsData = isset($_GET['id']) ? $group->fetchOneGroup($_GET['id']) : $group->fetchAllGroups();

    $resultsInfo = $db->executeCall($username, 1000, 86400);
    if ($resultsData === 0) {
      $message = "No group ";
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

    $groupReceived = json_decode(file_get_contents("php://input"));
    if (!isset($groupReceived)) {
      $groupReceived = json_decode($_POST["body"]);
    }
    $results = $group->insertGroup($groupReceived, $userId);
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

    $groupReceived = json_decode(file_get_contents("php://input"));
    if ($groupReceived->id <= 0) {
      $http->badRequest("Please an id is required to make a PUT request");
      exit();
    }
    $results = $db->fetchOneGroup($groupReceived->id);
    if ($results === 0) {
      $http->notFound("Group with the id $groupReceived->id was not found");
    } else if(false && $results['user_id'] !== $userId) {//TODO check if the user is an admin
      $http->notAuthorized("You are not authorized to update this group (" . $results['user_id'] . ":" . $userId . ")");
    } else {
      $parameters = [
        'id' => $groupReceived->id,
        'name' => isset($groupReceived->name) ? $groupReceived->name : $results['name'],
        'private' => isset($groupReceived->private) ? $groupReceived->private : $results['private']
      ];

      $resultsData = $group->updateGroup($parameters);
      $resultsInfo = $db->executeCall($username, 1000, 86400);

      if ($resultsInfo === -1)  {
        $http->paymentRequired();
      }else {
        $http->OK($resultsInfo, $resultsData);
      }
    }
    break;
}
