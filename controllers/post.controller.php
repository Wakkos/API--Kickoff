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

  static public function registerNewUser($table, $data) {
    $response = PostModel::registerNewUser($table, $data);
    if($response = "Ya Existe ese email") {
      self::fncResponse($response, "registerUser", 409);
    }
  }



    use ResponseTrait;
  }