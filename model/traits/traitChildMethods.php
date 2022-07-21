<?php
trait ChildMethods
{
  function __construct($sqlResponse)
  {
    parent::__construct($sqlResponse);
    try {
      foreach ($this->privateFields as $field) {
        $this->$field = $sqlResponse[$field];
      }
    } catch (Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function getAttributes()
  {
    $attributes = parent::getAttributes();
    foreach ($this->privateFields as $field) {
      $attributes[$field] = $this->$field;
    }
    return $attributes;
  }

  function save()
  {
    $insert_id = parent::save();

    if ($insert_id) {
      $privateFieldValues = [];
      foreach ($this->privateFields as $field) {
        array_push($privateFieldValues, $this->$field);
      };

      $privateFieldsStringified = join(', ', $this->privateFields);
      $qMarkForExtraFields = str_repeat(", ?", count($privateFieldValues));
      echo $privateFieldsStringified, $qMarkForExtraFields;
      // $weight = $this->weight;
      $_tableName = self::CHILD_TABLE;
      $_privateFieldDataTypes = $this->privateFieldDataTypes;

      $stmtResult = $this->insert(
        "INSERT INTO $_tableName (product_id, $privateFieldsStringified) VALUES (?$qMarkForExtraFields);",
        [$_privateFieldDataTypes, $insert_id, ...$privateFieldValues]
      );

      ['insert_id' => $insert_id, 'error' => $error] = $stmtResult;
      if ($insert_id) {
        return $this->getAttributes();
      }
      return $error;
    }
  }
}