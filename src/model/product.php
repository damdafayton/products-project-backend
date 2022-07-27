<?php

namespace model;

use utils;

abstract class Product extends Database
{
  protected $product_id;
  protected $sku;
  protected $name;
  protected $price;
  protected $description;
  protected $category;

  function __construct($modelData)
  {
    parent::__construct();
    // Data coming from sql is saved into instance variables to access data through instance objects. 
    // By this process, database can be changed by reading values from instance during creating or updating new items.

    try {
      $this->sku = $modelData['sku'];
      $this->name = $modelData['name'];
      $this->price = $modelData['price'];
      $this->description = $modelData['description'];
      $this->category = $modelData['category'];
      // New products dont have product_id until create() is called.
      $this->product_id = isset($modelData['product_id']) ? $modelData['product_id'] : null;
    } catch (\Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  protected function getAttributes()
  {
    return [
      'name' => $this->name, 'price' => $this->price, 'sku' => $this->sku,
      'description' => $this->description, 'category' => $this->category,
      'product_id' => $this->product_id
    ];
  }

  protected function create()
  {
    $_mainTable = utils\modelNameToTableName(__CLASS__, __NAMESPACE__);

    [
      'sku' => $sku, 'name' => $name, 'price' => $price,
      'description' => $description, 'category' => $category
    ] = $this->getAttributes();

    $stmtResult =  self::insert("INSERT INTO $_mainTable (sku, name, price, category, description) 
      VALUES (?, ?, ?, ?, ?);
    ", ['ssdss', $sku, $name, $price, $category, $description]);

    ['insert_id' => $insert_id, 'error' => $error] = $stmtResult;
    if ($insert_id) {
      $this->product_id = $insert_id;
      return $insert_id;
    } else if ($error) {
      // Handle error notifications.
      return $error;
    }
  }

  // QUERY METHODS ARE STATIC

  static function all()
  // Returns sql query result.
  {
    $_mainTable = utils\modelNameToTableName(__CLASS__, __NAMESPACE__);

    $allProducts =  self::select("SELECT * FROM $_mainTable ORDER BY product_id");
    $getPrivateFields = function ($product) {
      $categoryTable = $product['category'];
      $productId = $product['product_id'];
      $productSpecialFields = self::select("SELECT * from $categoryTable WHERE product_id = ?", ['s', $productId]);
      $productSpecialFields = count($productSpecialFields) > 0 ? $productSpecialFields[0] : [];
      return array_merge($product, $productSpecialFields);
    };
    return array_map($getPrivateFields, $allProducts);
  }

  static function getById($id)
  // Returns instance of correct product model.
  {
    $_mainTable = utils\modelNameToTableName(__CLASS__, __NAMESPACE__);

    $sqlQueryResult =  self::executeMultiQuery(
      "
          SET @category_table_name:= (SELECT category FROM $_mainTable where product_id = $id);
          SET @sql:= CONCAT('SELECT * FROM $_mainTable LEFT JOIN ', @category_table_name,' ON products.product_id = ', @category_table_name, '.product_id', ' WHERE products.product_id = $id');
          PREPARE dynamic_statement FROM @sql;
          EXECUTE dynamic_statement;
          DEALLOCATE PREPARE dynamic_statement;"
    );

    if ($sqlQueryResult['product_id'] > 0) {
      $category = $sqlQueryResult['category'];

      $Model = utils\tableNameToModelName($category, __NAMESPACE__);

      $modelInstance = new $Model($sqlQueryResult);
      return $modelInstance;
    } else {
      return null;
    }
  }

  static function massDelete($productListToDelete = [])
  {
    $_mainTable = utils\modelNameToTableName(__CLASS__, __NAMESPACE__);

    $response = null; // set before in case empty list is provided
    foreach ($productListToDelete as $productId) {
      $query = "
        SET @category_table_name:= (SELECT category FROM $_mainTable where product_id = $productId);
        SET @sql:= CONCAT('DELETE FROM ', @category_table_name,' WHERE product_id = $productId');
        PREPARE dynamic_statement FROM @sql;
        EXECUTE dynamic_statement;
        DEALLOCATE PREPARE dynamic_statement;
        DELETE FROM $_mainTable WHERE product_id = $productId; 
        ";
      $response = self::executeMultiQuery($query);
    }
    return $response;
  }

  static function getFields($category = null)
  {
    function isFieldNecessary($column)
    {
      $unNeccessaryFieldNames = ['product_id', 'id', 'category'];
      $fieldName = $column['Field'];

      return !in_array($fieldName, $unNeccessaryFieldNames);
    }

    $tableName = utils\modelNameToTableName(__CLASS__, __NAMESPACE__);

    if ($category) {
      // IF CATEGORY IS GIVEN RETURN THE FIELDS OF THAT CATEGORY
      $query = "SHOW FULL COLUMNS FROM $category";
      $showColumns = self::select($query);

      $categoryFields = array_values(array_map(
        function ($column) {
          return [$column['Field'], $column['Comment']];
        },
        array_filter($showColumns, 'model\isFieldNecessary')
      ));

      return ['categoryFields' => $categoryFields];
    } else {
      // IF CATEGORY IS NOT GIVEN RETURN THE CATEOGRY LIST
      $query = "SHOW COLUMNS FROM $tableName";
      $showColumns = self::select($query);

      $commonFields = array_values(array_map(
        function ($column) {
          return $column['Field'];
        },
        array_filter($showColumns, 'model\isFieldNecessary')
      ));

      // extract categories from `enums`
      $categoriesEnumString = array_values(array_filter(
        $showColumns,
        function ($column) {
          return $column['Field'] == 'category';
        }
      ))[0]['Type']; // "enum('books','dvds','furnitures')"
      $categoriesEnumString = str_replace('\'', '', $categoriesEnumString); // "enum(books,dvds,furnitures)"
      $categoriesList = explode(',', substr($categoriesEnumString, 5, (strlen($categoriesEnumString) - 6)));

      return ['commonFields' => $commonFields, 'categoryList' => $categoriesList];
    }
  }
}