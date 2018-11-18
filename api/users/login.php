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

$db = new Database();
$http = new HttpResponse();
$user = new User($db);
$auth = new Authenticate($db);

// Only POST requests are accepted
if (!$_SERVER['REQUEST_METHOD'] === "POST") {
  $http->badRequest("Invalid request for login");
  exit();
}


// Authenticate the user
$userId = 0;
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
$authResult = $auth->authenticate($username, $password);

// Validate the authentication results
if ($authResult['id'] > 0) {
  $userId = $authResult['id'];
  // The password doesn't need to be sent to the client
  $authResult['password'] = '';
  $resultsInfo = $db->executeCall($username, 1000, 86400);
  $http->OK($resultsInfo, $authResult);
} else { // Invalid authentication
  switch ($authResult) {
    case -1:
      $http->notAuthorized("You must authenticate yourself before you can use our REST API services");
      break;
    case -2:
      $http->notAuthorized("You provided wrong credentials");
      break;
  }
}

// // User should inform their credentials
// if (trim($_SERVER['PHP_AUTH_USER']) == '' || trim($_SERVER['PHP_AUTH_PW']) == '') {
//   $http->notAuthorized("You must authenticate yourself before you can use our REST API services");
//   exit();
// }
//
// // Check if the user provided correct credentials
// $username = $_SERVER['PHP_AUTH_USER'];
// $password = $_SERVER['PHP_AUTH_PW'];
// $query = "SELECT * FROM users WHERE username = ?";
// $results = $db->fetchOne($query, $username);
// if ($results === 0 || $results['password'] !== md5($password)) {
//     $http->notAuthorized("You provided wrong credentials");
//     exit();
// } else {
//     // The password doesn't need to be sent to the client
//     $results['password'] = '';
//     $resultsInfo = $db->executeCall($username, 1000, 86400);
//     $http->OK($resultsInfo, $results);
// }
