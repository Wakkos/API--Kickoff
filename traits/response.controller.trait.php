<?php
  trait ResponseTrait {
    public static function fncResponse($response, $endpoint) {
      if(!empty($response)) {
        $json = array(
          'status' => 200,
          'total' => count($response),
          'endpoint' => $endpoint,
          'results' => $response
        );
      } else {
        $json = array(
          'status' => 404,
          'total' => count((is_countable($response)?$response:[])),
          'endpoint' => $endpoint,
          'results' => "Not Found"
        );
      }

      echo json_encode($json, http_response_code($json["status"]));
    }
  }