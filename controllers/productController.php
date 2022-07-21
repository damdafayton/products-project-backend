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
      ['category' => $category] = $_POST;
      $Model = tableToClassName($category);

      if (class_exists($Model)) {
        $newEntry = new $Model($_POST);
        // print_r($newEntry->getAttributes());
        $result = $newEntry->save();
        print_r($result);
      } else {
        print '</br>Missing data!';
      }
    } catch (Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function massOperations($Class, $command)
  {
    echo "</br>MASS OPERATION REQUEST RECEIEVED </br>";
    ['list' => $list] = $_POST;
    $result = $Class::$command(json_decode($list));
    print_r($result);
  }
}