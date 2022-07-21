<?php
class Book extends Product
{
  private const CHILD_TABLE = 'books';
  use Weight;
  use ChildMethods;


  function save()
  {
    $insert_id = parent::save();

    if ($insert_id) {
      $weight = $this->weight;
      $_tableName = self::CHILD_TABLE;

      $stmtResult = $this->insert(
        "INSERT INTO $_tableName (product_id, weight) VALUES (?, ?);",
        ['ss', $insert_id, $weight]
      );

      ['insert_id' => $insert_id, 'error' => $error] = $stmtResult;
      if ($insert_id) {
        return $this->getAttributes();
      }
      return $error;
    }
  }
}