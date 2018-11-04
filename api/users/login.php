<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");

require_once "../../config/Database.php";
require_once "../../models/HttpResponse.php";
require_once "../../models/User.php";

$db = new Database();
$http = new HttpResponse();
$user = new User($db);

// Only POST requests are accepted
if (!$_SERVER['REQUEST_METHOD'] === "POST") {
  $http->badRequest("Invalid request for login");
  exit();
}

// User should inform their credentials
if (trim($_SERVER['PHP_AUTH_USER']) == '' || trim($_SERVER['PHP_AUTH_PW']) == '') {
  $http->notAuthorized("You must authenticate yourself before you can use our REST API services");
  exit();
}

// Check if the user provided correct credentials
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
$query = "SELECT * FROM users WHERE username = ?";
$results = $db->fetchOne($query, $username);
if ($results === 0 || $results['password'] !== $password) {
    $http->notAuthorized("You provided wrong credentials");
    exit();
} else {
    // The password doesn't need to be sent to the client
    $results['password'] = '';
    $resultsInfo = $db->executeCall($username, 1000, 86400);
    $http->OK($resultsInfo, $results);
}
