<?php
require_once PROJECT_ROOT_PATH . "/controllers/baseController.php";

class ProductController extends BaseController
{
  function index()
  {
    $products = Product::all();
    $this->sendOutput($products);
  }

  function show($id)
  {
    $product = Product::getById($id);
    $this->sendOutput($product->getAttributes());
  }

  function create()
  {
    echo 'POST REQUEST RECEIEVED';
    try {
      ['category' => $category, 'SKU' => $SKU, 'name' => $name, 'price' => $price, 'description' => $description] = $_POST;
      // echo $SKU, $name, $price;
      // $newProduct = new Product($SKU, $name, $price, $description);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}