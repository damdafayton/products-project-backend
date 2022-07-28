<?php

namespace controllers;

use utils;

class ProductController extends BaseController
{
  function index()
  {
    $allProducts = parent::index();

    $getPrivateFields = function ($product) {
      $model = utils\controllerNameToModelName($this, __NAMESPACE__);
      $returnArray =  ['product' => $product];

      $categoryTable = $product['category'];
      $productId = $product['product_id'];

      // Get fields from category specific table
      $productSpecialFields = $model::queryIdFromCategoryTable($categoryTable, $productId);

      if (count($productSpecialFields) > 0) {
        // Remove id fields and leave only special fields such as: size, weight, etc..
        $productSpecialFields = array_filter($productSpecialFields[0], function ($field) {
          return $field !== 'id' && $field !== 'product_id';
        }, ARRAY_FILTER_USE_KEY);

        global $categoryFields;
        $categoryFields = $model::getFields($categoryTable)['categoryFields'];
        // print_r($categoryFields);
        // Loop to convert ([weight] => 2.00) to ([weight] => [2.00, kg])
        foreach ($productSpecialFields as $key => $value) {
          $productSpecialFields[$key] = [$value, $categoryFields[$key]];
        }

        // Check if product has dimensions or other mergeable attributes
        $productSpecialFields = utils\product\joinFields($productSpecialFields);

        $returnArray['productSpecialFields'] = $productSpecialFields;
      }

      return $returnArray;
    };

    return $this->sendOutput(array_map($getPrivateFields, $allProducts));
  }

  function show($id)
  {
    $queryResult = parent::show($id);

    // If product is found
    if ($queryResult['product_id'] > 0) {
      $category = $queryResult['category'];

      $Model = utils\tableNameToModelName($category, 'model');

      $modelInstance = new $Model($queryResult);

      return $this->sendOutput($modelInstance->getAttributes());
    } else {
      $this->exit('Id not found');
    }
  }

  function create()
  {
    try {
      $json = $this->parseJSON();
      ['category' => $category] = $this->parseJSON();

      $model = utils\tableNameToModelName($category, 'model');

      if (class_exists($model)) {
        $instance = new $model($json);
        $result = $instance->create();

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
    $queryResult = parent::massOperations($command);

    $this->sendOutput($queryResult);
  }
}