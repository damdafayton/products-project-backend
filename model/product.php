<?php
// Keep this for seeding model.
require_once PROJECT_ROOT_PATH . './model/database.php';

abstract class Product extends Database
{
  use ParentMethods;
  const MAIN_TABLE = 'products';

  protected $product_id;
  protected $sku;
  protected $name;
  protected $price;
  protected $description;
  protected $category;

  function __construct($sqlResponse)
  {
    parent::__construct();

    /* protected attributes will be used while inserting new entry into database. 
    /* So sterilize the incoming data.
    */
    try {
      $this->sku = $sqlResponse['sku'];
      $this->name = $sqlResponse['name'];
      $this->price = $sqlResponse['price'];
      $this->description = $sqlResponse['description'];
      $this->category = $sqlResponse['category'];
      $this->product_id = $sqlResponse['product_id'];
    } catch (Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function getAttributes()
  {
    return [
      'name' => $this->name, 'price' => $this->price, 'sku' => $this->sku,
      'description' => $this->description, 'category' => $this->category,
      'product_id' => $this->product_id
    ];
  }

  function save()
  {
    $_mainTable = self::MAIN_TABLE;

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
      echo $error;
      return 0;
    }
  }
}