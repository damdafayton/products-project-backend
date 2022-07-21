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
      $_tableName = strtolower(__CLASS__) . 's';
      $_privateFieldDataTypes = $this->privateFieldDataTypes;

      $stmtResult = $this->insert(
        "INSERT INTO $_tableName (product_id, $privateFieldsStringified) VALUES (?$qMarkForExtraFields);",
        ['s' . $_privateFieldDataTypes, $insert_id, ...$privateFieldValues]
      );

      ['insert_id' => $insert_id, 'error' => $error] = $stmtResult;
      if ($insert_id) {
        return $this->getAttributes();
      }
      return $error;
    }
  }

  static function all()
  // Returns sql query result.
  {
    $_categoryTable = strtolower(__CLASS__) . 's';
    $_mainTable = strtolower(get_parent_class(__CLASS__)) . 's';

    return self::select(
      "SELECT * FROM $_mainTable WHERE category = ? ORDER BY product_id",
      ['s', $_categoryTable]
    );
  }
}