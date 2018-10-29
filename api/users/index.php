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
require_once "../../models/User.php";
require_once "../../models/HttpResponse.php";
require_once "../../models/Authenticate.php";

$db = new Database();
$user = new User($db);
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

    //If there is an argument
    if (isset($_GET['argument'])) {
      // Filter by id
      if (filter_var($_GET['argument'], FILTER_VALIDATE_INT)) {
        $resultsData = $user->fetchOneUser($_GET['argument'], $userId);
      // Filter by name or email
      } else {
        $resultsData = $user->fetchUsersByNameOrEmail($_GET['argument'], $userId);
      }
    } else {
      // Fetch all users
      $resultsData = $user->fetchAllUsers();
    }

    // Deal with the results
    $resultsInfo = $db->executeCall($username, 1000, 86400);
    if ($resultsData === 0) {
      $message = "No user ";
      $message .= isset($_GET['argument']) ? "with the parameter " . $_GET['argument'] : "";
      $message .= " was found";
      $http->notFound($message);
    } else if ($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $resultsData);
    }

    break;

  case "POST":

    $userReceived = json_decode($_POST['body']);
    $results = $user->insertUser($userReceived);
    $resultsInfo = $db->executeCall($username, 1000, 86400);
    if ($results === -1) {
      $http->badRequest("A valid JSON of username, password... fields is required");
    }else if($resultsInfo === -1) {
      $http->paymentRequired();
    }else {
      $http->OK($resultsInfo, $results);
    }
    break;

  case "PUT":

    $userReceived = json_decode(file_get_contents("php://input"));
    if ($userReceived->id <= 0) {
      $http->badRequest("Please an id is required to make a PUT request");
      exit();
    }
    $results = $db->fetchOneUser($userReceived->id);
    if ($results === 0) {
      $http->notFound("User with the id $userReceived->id was not found");
    } else {
      $parameters = [
        'id' => $userReceived->id,
        'username' => isset($userReceived->message) ? $userReceived->message : $results['username'],
      ];

      $resultsData = $user->updateUser($parameters);
      $resultsInfo = $db->executeCall($username, 1000, 86400);

      if ($resultsInfo === -1)  {
        $http->paymentRequired();
      }else {
        $http->OK($resultsInfo, $resultsData);
      }
    }

    break;
}

// // CHECK INCOMING GET REQUESTS
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
//         // ERROR ONLY INTEGER IS ALLOWED
//         $http->badRequest("Only a valid integer is allowed to fetch a single user");
//         die();
//     }
//     // FETCH ONE USER IF ID EXISTS OR ALL IF ID DOESN'T EXIST
//     $resultsData = isset($_GET['id']) ? $user->fetchOneUser($_GET['id']) : $user->fetchAllUsers();
//     $resultsInfo = $db->executeCall($username, 1000, 86400);
//
//     if ($resultsData === 0) {
//         $message = "No user ";
//         $message .= isset($_GET['id']) ? "with the id " . $_GET['id'] : "";
//         $message .= " was found";
//         $http->notFound($message);
//     } else if ($resultsInfo === -1) {
//       $http->paymentRequired();
//     }else {
//       $http->OK($resultsInfo, $resultsData);
//     }
// }
//
// else if ($_SERVER['REQUEST_METHOD'] === "POST") {
//     $userReceived = json_decode(file_get_contents("php://input"));
//     $results = $user->insertUser($userReceived, $user_id);
//     $resultsInfo = $db->executeCall($username, 1000, 86400);
//     if ($results === -1) {
//       $http->badRequest("A valid JSON of username, password... fields is required");
//     }else if($resultsInfo === -1) {
//       $http->paymentRequired();
//     }else {
//       $http->OK($resultsInfo, $results);
//     }
// }
//
// else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
//   $userReceived = json_decode(file_get_contents("php://input"));
//   if (!$userReceived->id) {
//     // POST ID NOT PROVIDED BAD REQUEST
//     $http->badRequest("Please an id is required to make a PUT request");
//     exit();
//   }
//   $query = "SELECT * FROM users WHERE id = ?";
//   $results = $db->fetchOne($query, $userReceived->id);
//   if ($results === 0) {
//     // Post NOT Found
//     $http->notFound("User with the id $userReceived->id was not found");
//   }else if($results['user_id'] !== $user_id) {
//     $http->notAuthorized("You are not authorized to update this user");
//   }else {
//     // USER CAN UPDATE
//     $parameters = [
//       'id' => $userReceived->id,
//       'username' => isset($userReceived->username) ? $userReceived->username : $results['username'],
//       'password' =>isset($userReceived->password) ? $userReceived->password : $results['password'],
//     ];
//
//     $resultsData = $user->updateUser($parameters);
//     $resultsInfo = $db->executeCall($username, 1000, 86400);
//
//     if ($resultsInfo === -1)  {
//       $http->paymentRequired();
//     }else {
//       $http->OK($resultsInfo, $resultsData);
//     }
//   }
// }
//
// else if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
//   $idReceived = json_decode(file_get_contents("php://input"));
//   if (!$idReceived->id) {
//     $http->badRequest("No id was provided");
//     exit();
//   }
//   $query = "SELECT * FROM users WHERE id = ?";
//   $results = $db->fetchOne($query, $idReceived->id);
//
//   if ($results === 0) {
//     // POST NOT FOUND
//     $http->notFound("User with the id $idReceived->id was not found");
//     exit();
//   }
//   if ($results['user_id'] !== $user_id) {
//     // NOT AUTHORIZED TO DELETE
//     $http->notAuthorized("You are not authorized to delete this user");
//   }else {
//     // User CAN NOW DELETE USER
//     $resultsData = $user->deleteUser($idReceived->id);
//     $resultsInfo = $db->executeCall($username, 1000, 86400);
//
//     if ($resultsInfo === -1) {
//       $http->paymentRequired();
//     }else {
//       $http->OK($resultsInfo, $resultsData);
//     }
//   }
// }
