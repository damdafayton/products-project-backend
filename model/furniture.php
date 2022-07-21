<?php
class Furniture extends Product
{
  private const CHILD_TABLE = 'furnitures';
  use Dimensions;
  use ChildMethods;

  function save()
  {
    $insert_id = parent::save();
    if ($insert_id) {
      $height = $this->height;
      $width = $this->width;
      $length = $this->length;
      $_tableName = self::CHILD_TABLE;

      $stmtResult = $this->insert("INSERT INTO $_tableName (product_id, height, width, length) VALUES (?, ?, ?, ?);", [
        'siii', $insert_id, $height, $width, $length
      ]);

      ['insert_id' => $insert_id, 'error' => $error] = $stmtResult;
      if ($insert_id) {
        return $this->getAttributes();
      }
      return $error;
    }
  }
}