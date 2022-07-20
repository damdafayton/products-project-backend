<?php
require_once PROJECT_ROOT_PATH . './model/product.php';

class Book extends Product
{
  private $sqlTable = 'books';
  protected $weight = null;

  function __construct($sqlResponse)
  {
    parent::__construct($sqlResponse);
    ['product_id' => $product_id] = $sqlResponse;
    $specialAttributes = $this->select("SELECT * FROM $this->sqlTable WHERE product_id = ?", ['s', $product_id]);
    $this->attributes['weight'] = $specialAttributes[0]['weight'];
  }
}