<?php
  // TODO: Refactor all variables in any SQL query into params
  require_once "connection.php";
  require_once "vendor/autoload.php";
  require_once "traits/get-model/get.model.utilities.php";



  class GetModel {

    use GetModelUtilityTraits;

  }