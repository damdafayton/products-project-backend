<?php
require_once '../model/database.php';
require_once '../config/configuration.php';


class Seeding extends Database
{
  function executeListOfQueries($listOfQueries)
  {
    $result = null;
    foreach ($listOfQueries as $query) {
      $result = $this->createOrInsert($query);
      if (!$result) {
        continue;
      }
      echo $result;
    }
  }

  function executeListOfMultipleQueries($listOfMulipleQueries)
  {
    $result = null;
    foreach ($listOfMulipleQueries as $query) {
      $result = $this->executeMultiQuery($query);
      if (!$result) {
        continue;
      }
      echo $result;
    }
  }
}