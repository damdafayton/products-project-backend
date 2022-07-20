<?php
trait staticClassMethods
{
  /**
   * $tableName must be defined in child classes.
   * static functions which query the database and return the correct instance
   */

  static function all()
  {
    $instance = new class extends Database
    {
      function _all($_tableName)
      {
        return $this->select("SELECT * FROM $_tableName ORDER BY product_id");
      }
    };
    return $instance->_all(self::$tableName);
  }

  static function getById($id)
  {
    $instance = new class extends Database
    {
      function _getById($_tableName, $_id)
      {
        return $this->select(
          "SELECT * FROM $_tableName LEFT JOIN WHERE product_id = ?",
          ['s', $_id]
        );
      }
    };
    $sql = $instance->_getById(self::$tableName, $id);
    $category = $sql[0]['category'];
    $model = ucwords((strtolower(substr($category, 0, strlen($category) - 1))));
    // print_r($sql[0]);
    $modelInstance = new $model($sql[0]);
    return $modelInstance;
  }
}