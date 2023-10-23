<?php

trait PostControllerUtilityTraits {

  //-----> Post request to add data
  static public function postData($table, $data) {
    $response = PostModel::postData($table, $data);

    self::fncResponse($response, "postData");
  }
}