<?php

  require_once "models/get.model.php";
  require_once "vendor/autoload.php";
  require_once "traits/get-controller/get.controller.utilities.php";
  require_once "traits/response.controller.trait.php";


  class GetController {

    use GetControllerUtilityTraits;

    use ResponseTrait;
  }