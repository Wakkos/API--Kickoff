<?php

require_once "models/connection.php";

class PostController {

 //-----> Post request to add new Test

  static public function postLogin($table, $data) {
    echo json_encode($data);
  }


  //-----> Post request to add data
  static public function postData($table, $data) {
    $response = PostModel::postData($table, $data);

    $return = new PostController();
    $return -> fncResponse($response, null);
  }




  //-----> Controller response
  public function fncResponse($response, $error, $status = 200) {
    $json = array();

    if(!empty($response)) {
      $json = array(
        'status' => $status,
        'results' => $response
      );
    }
    else {
      $json = array(
        'status' => $status,
        'results' => $error ?? "Not Found"
      );
    }

    http_response_code($json["status"]);
    echo json_encode($json);
  }
}