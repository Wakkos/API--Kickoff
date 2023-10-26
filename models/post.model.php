<?php

  require_once "models/put.model.php";
  require_once "traits/post-model/post.model.utilities.php";
  require_once "traits/post-model/post.model.user.functions.php";



  class postModel {

    use PostModelUtilityTraits;

    use PostModelUserFunctionsTraits;

  }