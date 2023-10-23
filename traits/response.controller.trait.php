<?php
  trait ResponseTrait {
    public static function fncResponse($response, $endpoint, $status = 200, $error = null, ) {
      if(!empty($response)) {

        if(!empty($response["lastId"])) {
          $json = array(
            'status' => $status,
            'endpoint' => $endpoint,
            'results' => $response
          );
        } else {
          $json = array(
            'status' => $status,
            'total' => count($response),
            'endpoint' => $endpoint,
            'results' => $response
          );
        }
      } else {
        $json = array(
          'status' => $status ?? 404,
          'endpoint' => $endpoint,
          'results' => $error ?? "Not Found"
        );
      }

      echo json_encode($json, http_response_code($json["status"]));
    }
  }