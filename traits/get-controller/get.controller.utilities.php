
<?php
trait GetControllerUtilityTraits {



  //-----> Get request
  static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt) {
    $response = GetModel::getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
    self::fncResponse($response, "getData");
  }

  //-----> Get request, with Filter
  static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt) {
    $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

    self::fncResponse($response, "getDataFilter");
  }

  //-----> Get Requests WITHOUT filter among RELATED TABLES
  static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt) {
    $response = GetModel::getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt);

    self::fncResponse($response, "getRelData");
  }

  //-----> Get Requests WITH filter among RELATED TABLES
  static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt) {
    $response = GetModel::getRelDataFilter($rel, $type, $select ,$linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);


    self::fncResponse($response, "getRelDataFilter");
  }

}