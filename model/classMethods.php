<?php
trait classMethods
{
  // $tableName must be defined in child classes
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
        return $this->select("SELECT * FROM $_tableName WHERE product_id = ?", ['s', $_id]);
      }
    };
    return $instance->_getById(self::$tableName, $id);
  }
}