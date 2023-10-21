<?php
require_once "models/connection.php";
require_once "controllers/get.controller.php";
require_once "functions/token-validation.php";

$response = new GetController();


if($table == "verify-email" && isset($_GET["token"])) {
	$response -> verifyEmail($_GET["token"]);
	exit;
}

// At this point, verify email has been handled and is no longer needed.
// So, we will now handle the token verification.
if (isset($_GET["token"])) {
	validateToken($_GET["token"]);
} else {
	$json = array(
			'status' => 401,
			'results' => "Error: No token provided."
	);
	echo json_encode($json, http_response_code($json["status"]));
	exit;
}

// If we get to this point, we know that a valid token has been provided.
// So, we can now safely handle the other GET actions.


$select = $_GET["select"] ?? "*";
$orderBy = $_GET["orderBy"] ?? null;
$orderMode = $_GET["orderMode"] ?? null;
$startAt = $_GET["startAt"] ?? null;
$endAt = $_GET["endAt"] ?? null;
$userID = $_GET["userID"] ?? null;

//-----> Request WITHOUT filter
  $response -> getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);