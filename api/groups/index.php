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

$db = new Database();
$group = new Group($db);
$http = new HttpResponse();

if (!isset($_SESSION['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])) {
    $http->notAuthorized("You must authenticate yourself before you can use our REST API services");
    exit();
} else {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $query = "SELECT * FROM users WHERE username = ?";
    $results = $db->fetchOne($query, $username);
    if ($results === 0 || $results['password'] !== $password) {
        $http->notAuthorized("You provided wrong credentials");
        exit();
    } else {
        $user_id = $results['id'];
    }
}

// CHECK INCOMING GET REQUESTS
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        // ERROR ONLY INTEGER IS ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch a single group");
        die();
    }
    // FETCH ONE GROUP IF ID EXISTS OR ALL IF ID DOESN'T EXIST
    $resultsData = isset($_GET['id']) ? $group->fetchOneGroup($_GET['id']) : $group->fetchAllGroups();
    $resultsInfo = $db->executeCall($username, 1000, 86400);

    if ($resultsData === 0) {
        $message = "No group ";
        $message .= isset($_GET['id']) ? "with the id " . $_GET['id'] : "";
        $message .= " was found";
        $http->notFound($message);
    } else if ($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      //print_r($resultsData);
      $http->OK($resultsInfo, $resultsData);
    }
} else if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //$groupReceived = json_decode(file_get_contents("php://input"));
    $groupReceived = json_decode($_POST["body"]);
    $results = $group->insertGroup($groupReceived, $user_id);
    $resultsInfo = $db->executeCall($username, 1000, 86400);
    if ($results === -1) {
      // $http->badRequest($groupReceived);
      $http->badRequest("A valid JSON of name and 'private' fields is required");
    }else if($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $results);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $groupReceived = json_decode(file_get_contents("php://input"));
  if (!$groupReceived->id) {
    // POST ID NOT PROVIDED BAD REQUEST
    $http->badRequest("Please an id is required to make a PUT request");
    exit();
  }
  $query = "SELECT * FROM groups WHERE id = ?";
  $results = $db->fetchOne($query, $groupReceived->id);
  if ($results === 0) {
    // Post NOT Found
    $http->notFound("Group with the id $groupReceived->id was not found");
  }else if($results['user_id'] !== $user_id) {
    $http->notAuthorized("You are not authorized to update this group");
  }else {
    // USER CAN UPDATE
    $parameters = [
      'id' => $groupReceived->id,
      'body' => isset($groupReceived->name) ? $groupReceived->name : $results['name'],
      'private' =>isset($groupReceived->private) ? $groupReceived->private : $results['private'],
    ];

    $resultsData = $group->updateGroup($parameters);
    $resultsInfo = $db->executeCall($username, 1000, 86400);

    if ($resultsInfo === -1)  {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $resultsData);
    }
  }
} else if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
  $idReceived = json_decode(file_get_contents("php://input"));
  if (!$idReceived->id) {
    $http->badRequest("No id was provided");
    exit();
  }
  $query = "SELECT * FROM groups WHERE id = ?";
  $results = $db->fetchOne($query, $idReceived->id);

  if ($results === 0) {
    // POST NOT FOUND
    $http->notFound("Group with the id $idReceived->id was not found");
    exit();
  }
  if ($results['user_id'] !== $user_id) {
    // NOT AUTHORIZED TO DELETE
    $http->notAuthorized("You are not authorized to delete this group");
  }else {
    // User CAN NOW DELETE GROUP
    $resultsData = $group->deleteGroup($idReceived->id);
    $resultsInfo = $db->executeCall($username, 1000, 86400);

    if ($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $resultsData);
    }
  }

}
