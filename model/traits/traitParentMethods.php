<?php
trait ParentMethods
{
  /**
   * Static parent functions
   * These methods are kept here in case in the future we add new parent classes such as Users, Customers
   */

  static function all()
  // Returns sql query result.
  {
    $_mainTable = strtolower(__CLASS__) . 's';
    return self::select("SELECT * FROM $_mainTable ORDER BY product_id");
  }

  static function getById($id)
  // Returns instance of correct product model.
  {
    $_mainTable = strtolower(__CLASS__) . 's';

    $sqlQueryResult =  self::executeMultiQuery(
      "
          SET @category_table_name:= (SELECT category FROM $_mainTable where product_id = $id);
          SET @sql:= CONCAT('SELECT * FROM $_mainTable LEFT JOIN ', @category_table_name,' ON products.product_id = ', @category_table_name, '.product_id', ' WHERE products.product_id = $id');
          PREPARE dynamic_statement FROM @sql;
          EXECUTE dynamic_statement;
          DEALLOCATE PREPARE dynamic_statement;"
    );

    if ($sqlQueryResult) {
      $category = $sqlQueryResult['category']; // books
      $Model = tableToClassName($category); // Book

      $modelInstance = new $Model($sqlQueryResult);

      return $modelInstance;
    } else {
      // handle null return
    }
  }

  static function massDelete($productListToDelete = [])
  {
    $_mainTable = strtolower(__CLASS__) . 's';
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
}