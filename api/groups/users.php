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

if (!isset($_GET['id'])) {
  // USER ID MUST BE PROVIDED
  $http->badRequest("Please provide the user id to fetch the groups relating to that particular user");
  exit();
}
if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
  // ERROR ONLY INTEGERS ARE ALLOWED
  $http->badRequest("Only Integers are allowed");
  exit();
}

$id = $_GET['id'];
$resultsData = $group->fetchUsersGroup($id);
$resultsInfo = $db->executeCall($username, 1000, 86400);

if ($resultsData === 0) {
  $http->notFound("User with the id $id groups doesn't exist");
}else if ($resultsInfo === -1) {
  $http->paymentRequired();
}else {
  $http->OK($resultsInfo, $resultsData);
}
