<?php
trait ChildMethods

/**  
 * Child methods extend methods from the parent Product class. 
 * When saving/creating a product, initially common fields are created in products table,
 * this action is handled by Product class,
 * Then, fields special to the category of the product are saved into a seperate table,
 * this action is handled by classes extended from Product class.
 * Same logic is used when creating an instance and retrieving attributes.
 */

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

  function create()
  {
    $insert_id = parent::create();

    if ($insert_id) {
      $privateFieldValues = [];
      foreach ($this->privateFields as $field) {
        array_push($privateFieldValues, $this->$field);
      };

      $privateFieldsStringified = join(', ', $this->privateFields);
      $qMarkForExtraFields = str_repeat(", ?", count($privateFieldValues));

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
      return ["error" => $error];
    }
  }

  static function all()
  // Returns sql query result.
  {
    $_categoryTable = strtolower(__CLASS__) . 's';
    $_mainTable = strtolower(get_parent_class(__CLASS__)) . 's';

    $allProductsUnderCategory = self::select(
      "SELECT * FROM $_mainTable WHERE category = ? ORDER BY product_id",
      ['s', $_categoryTable]
    );

    $getPrivateFields = function ($product) {
      $categoryTable = $product['category'];
      $productId = $product['product_id'];
      $productSpecialFields = self::select("SELECT * from $categoryTable WHERE product_id = ?", ['s', $productId]);
      return array_merge($product, $productSpecialFields[0]);
    };
    return array_map($getPrivateFields, $allProductsUnderCategory);
  }
}
