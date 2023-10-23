<?php
require_once "models/connection.php";
require_once "models/get.model.php";
require_once "controllers/post.controller.php";
require_once "functions/token-validation.php";

$response = new PostController();

// Register User
if (isset($_GET["register"]) && $_GET["register"] == true) {
    $response->registerNewUser($table, $_POST);
    exit;
}

// Login User
if (isset($_GET["login"]) && $_GET["login"] == true) {
    $response->postLogin($table, $_POST);
    exit;
}

// At this point, login and register have been handled and are no longer needed.
// So, we will now handle the token verification.

// We lowercase all headers inc ase server (Apache sometimes does it) converts it into Capital word
$headers = array_change_key_case(getallheaders(), CASE_LOWER);
if (isset($headers["token"])) {
    validateToken($headers["token"]);
} else {
    $json = array(
        'status' => 401,
        'results' => "Error: No token provided."
    );
    echo json_encode($json, http_response_code($json["status"]));
    exit;
}

// If we get to this point, we know that a valid token has been provided.
// So, we can now safely handle the other POST actions.

if (isset($_POST)) {

    // Insert any POST
	$columns = array();
	foreach (array_keys($_POST) as $key => $value) {
		array_push($columns, $value);
	}


	//-----> Validate table and columns exist on DB
	if(empty(Connection::getColumnsData($table, $columns))) {
		$json = array(
			'status' => 400,
			'results' => "Error: Fields sent doesn't match Database fields"
		);
		echo json_encode($json, http_response_code($json["status"]));
		return;
	}

	//-----> Ask a response from controller to insert data on any table
	$response = new PostController();
	$response -> postData($table, $_POST);
}