<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use \Stripe\Exception\ApiErrorException;


  require_once "models/post.model.php";
  require_once "models/get.model.php";
  require_once "traits/post-controller/post.controller.utilities.php";
  require_once "traits/post-controller/post.controller.users.functions.php";
  require_once "traits/response.controller.trait.php";




  class postController {

    use postControllerUtilityTraits;

    use postControllerUsersTraits;

    use ResponseTrait;
  }