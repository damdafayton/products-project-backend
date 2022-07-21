<?php
class Dvd extends Product
{
  private const CHILD_TABLE = 'dvds';
  use Size;
  use ChildMethods;

  function save()
  {
    $insert_id = parent::save();

    if ($insert_id) {
      $size = $this->size;
      $_tableName = self::CHILD_TABLE;

      $stmtResult = $this->insert("INSERT INTO $_tableName (product_id, size) VALUES (?, ?);", [
        'si', $insert_id, $size
      ]);

      ['insert_id' => $insert_id, 'error' => $error] = $stmtResult;
      if ($insert_id) {
        return $this->getAttributes();
      }
      return $error;
    }
  }
}