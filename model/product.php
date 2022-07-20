<?php
require_once PROJECT_ROOT_PATH . './model/database.php';
require_once PROJECT_ROOT_PATH . './model/staticClassMethods.php';

abstract class Product extends Database
{
  use staticClassMethods;
  static $tableName = 'products';

  protected $attributes;

  function __construct($sqlResponse)
  {
    parent::__construct();
    $this->attributes = $sqlResponse;
  }

  function getAttributes()
  {
    return $this->attributes;
  }
}