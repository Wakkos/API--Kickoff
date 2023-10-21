<?php
require_once "models/connection.php";

function validateToken($token) {
  $validate = Connection::tokenValidation($token);

  if ($validate != "ok") {
      if ($validate == "expired") {
          $json = array(
              'status' => 303,
              'results' => "Error: Token has expired."
          );
      } elseif ($validate == "no-auth") {
          $json = array(
              'status' => 401,
              'results' => "Error: user not Authorized."
          );
      }
      echo json_encode($json, http_response_code($json["status"]));
      exit;
  }
}
