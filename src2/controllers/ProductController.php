<?php

namespace controllers;

use utils;

class ProductController extends BaseController
{

  function index()
  {
    $queryResult = parent::index();

    $this->sendOutput($queryResult);
  }

  function show($id)
  {
    $instance = parent::show($id);

    if ($instance) {
      $this->sendOutput($instance->getAttributes());
    } else {
      $this->exit();
    }
  }

  function create()
  {
    try {
      $string = file_get_contents("php://input");
      if ($string === false) {
        $this->sendOutput(["error" => "Send data in JSON format."]);
      }
      $json = json_decode($string, true);
      ['category' => $category] = $json;
      $Model = utils\tableNameToModelName($category, __NAMESPACE__);
      // echo $Model;

      if (class_exists($Model)) {
        $newEntry = new $Model($json);
        $result = $newEntry->create();

        $this->sendOutput($result);
      } else {
        $this->sendOutput(["error" => "Missing data!"]);
      }
    } catch (\Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function handleQueries()
  {
    $Model = utils\controllerNameToModelName($this, __NAMESPACE__);
    // substr(get_class($this), 0, -10); // ProductController to Product
    $queryList = parent::getQueryStringParams();

    if (array_key_exists('fields', $queryList)) {
      $fields = $Model::getFields($queryList['fields']);
      $this->sendOutput($fields);
    }
  }

  function massOperations($command)
  {
    $result = parent::massOperations($command);
    $this->sendOutput($result);
  }
}