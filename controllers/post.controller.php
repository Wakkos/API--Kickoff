<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use \Stripe\Exception\ApiErrorException;


  require_once "models/post.model.php";
  require_once "models/get.model.php";
  require_once "traits/response.controller.trait.php";




  class postController {

    //-----> Post request to add data
  static public function postData($table, $data) {
    $response = PostModel::postData($table, $data);

    self::fncResponse($response, "postData");
  }




  //-----> Post request to create a user
  static public function registerNewUser($table, $data) {
    $response = PostModel::registerNewUser($table, $data);
    if($response === "Ya Existe ese email") {
      self::fncResponse($response, "registerUser", 409);
    }

    else {
      self::fncResponse($response, "registerUser", 200);
    }
  }




  //-----> Post request to log a user in.
  static public function loginUser($table, $data) {
    $response = PostModel::loginUser($table, $data);
    if($response['success'] !== true) {
      self::fncResponse($response['message'], "loginUser", 401);
    }
    elseif($response['success'] === true) {
      self::fncResponse($response, "loginUser", 200);
    }
  }


    use ResponseTrait;
  }