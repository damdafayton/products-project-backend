<?php
require_once '../model/database.php';
require_once '../config/configuration.php';


class Seeding extends Database
{
  function executeListOfQueries($listOfQueries)
  {
    $result = null;
    foreach ($listOfQueries as $query) {
      $result = self::insert($query);
      if (!$result) {
        continue;
      }
      print_r($result);
    }
  }

  function executeListOfMultipleQueries($listOfMulipleQueries)
  {
    $result = null;
    foreach ($listOfMulipleQueries as $query) {
      $result = self::executeMultiQuery($query);
      if (!$result) {
        continue;
      }
      print_r($result);
    }
  }
}