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
// if ($authResult > 0) {
//   $userId = $authResult;
// } else if ($_SERVER['REQUEST_METHOD'] != 'POST') { // Invalid authentication
//   switch ($authResult) {
//     case -1:
//       $http->notAuthorized($_SERVER['REQUEST_METHOD'] . "You must authenticate yourself before you can use our REST API services");
//       break;
//     case -2:
//       $http->notAuthorized($_SERVER['REQUEST_METHOD'] . "You provided wrong credentials");
//       break;
//   }
//   exit();
// }

switch ($_SERVER['REQUEST_METHOD']) {
  case "GET":

    //If there is an argument
    if (isset($_GET['q'])) {
      $resultsData = $user->fetchUsersByNameOrEmail($_GET['q'], $userId);
      // Deal with the results
      $resultsInfo = $db->executeCall($username, 1000, 86400);
      // $http->OKSimple($resultsInfo, $resultsData);
    } else {
      // Fetch all users
      $resultsData = $user->fetchAllUsers();
      // $http->OKSimple("", "");
    }
    $resultsData = $_GET['callback'] . "(" . json_encode($resultsData) . ")";
    $http->OKSimple($resultsInfo, $resultsData);


    break;
}
