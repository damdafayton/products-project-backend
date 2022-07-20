<?php
require_once PROJECT_ROOT_PATH . './model/database.php';
require_once PROJECT_ROOT_PATH . './model/classMethods.php';

abstract class Product extends Database
{
  use classMethods;
  static $tableName = 'products';

  protected $id;

  function __construct($SKU, $name, $price, $description = null)
  {
    // CREATE NEW PRODUCT, RETURN DETAILS 
  }

  function getId()
  {
    return $this->id;
  }

  function setSKU()
  {
  }

  function setName()
  {
  }

  function setPrice()
  {
  }
}