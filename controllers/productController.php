<?php

class ProductController extends BaseController
{
  function create()
  {
    try {
      $string = file_get_contents("php://input");
      if ($string === false) {
        // deal with error...
      }
      $json = json_decode($string, true);
      ['category' => $category] = $json;

      $Model = tableToClassName($category);

      if (class_exists($Model)) {
        $newEntry = new $Model($json);
        $result = $newEntry->save();

        $this->sendOutput($result);
      } else {
        $this->sendOutput(["error" => "Missing data!"]);
      }
    } catch (Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function handleQueries()
  {
    $Model = substr(get_class($this), 0, -10); // ProductController to Product
    $queryList = $this->getQueryStringParams();
    if (array_key_exists('fields', $queryList)) {
      $fields = $Model::getFields($queryList['fields']);
      $this->sendOutput($fields);
      // print_r($fields);
    }
  }
}