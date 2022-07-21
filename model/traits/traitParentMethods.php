<?php
trait ParentMethods
{
  /**
   * $mainTable must be defined in child classes.
   * static functions which query the database
   * methods are under trait in case in the future we add main classes other than Product
   */

  static function all()
  // Returns sql query result.
  {
    $_mainTable = self::MAIN_TABLE;
    $_childTable = defined('CHILD_TABLE') ? self::CHILD_TABLE : null;
    if ($_childTable) {
      return self::select(
        "SELECT * FROM $_mainTable WHERE category = ? ORDER BY product_id",
        ['s', $_childTable]
      );
    } else {
      return self::select("SELECT * FROM $_mainTable ORDER BY product_id");
    }
  }

  static function _getById($id)
  // Returns instance of correct product model.
  {
    $_mainTable = self::MAIN_TABLE;
    $sqlQueryResult =  self::executeMultiQuery(
      "
          SET @category_table_name:= (SELECT category FROM $_mainTable where product_id = $id);
          SET @sql:= CONCAT('SELECT * FROM $_mainTable LEFT JOIN ', @category_table_name,' ON products.product_id = ', @category_table_name, '.product_id', ' WHERE products.product_id = $id');
          PREPARE dynamic_statement FROM @sql;
          EXECUTE dynamic_statement;
          DEALLOCATE PREPARE dynamic_statement;"
    );

    $category = $sqlQueryResult['category']; // books
    $Model = tableToClassName($category); // Book

    $modelInstance = new $Model($sqlQueryResult);

    return $modelInstance;
  }

  static function massDelete($productListToDelete = [])
  {
    $_mainTable = self::MAIN_TABLE;
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