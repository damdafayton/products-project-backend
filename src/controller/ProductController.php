<?php

namespace controller;

use utils;

class ProductController extends BaseController
{

  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $allProducts = parent::index();
    // print_r($allProducts);
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

    return $this->response->sendOutput(array_map($getPrivateFields, $allProducts));
  }

  function show()
  {
    $queryResult = parent::show();

    // If product is found
    if ($queryResult['product_id'] > 0) {
      $category = $queryResult['category'];

      $Model = utils\tableNameToModelName($category, 'model');

      $modelInstance = new $Model($queryResult);

      return $this->response->sendOutput($modelInstance->getAttributes());
    } else {
      $this->exit('Id not found');
    }
  }

  function create()
  {
    try {
      $body = $this->getParsedBody();
      ['category' => $category] = $this->getParsedBody();

      $model = utils\tableNameToModelName($category, 'model');

      if (class_exists($model)) {
        $instance = new $model($body);
        $result = $instance->create();

        $this->response->sendOutput($result);
      } else {
        $this->exit("Missing data!");
      }
    } catch (\Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function handleQueries()
  {
    $Model = utils\controllerNameToModelName($this, __NAMESPACE__);
    // substr(get_class($this), 0, -10); // ProductController to Product
    $queryList = $this->getQueryParams();

    if (array_key_exists('fields', $queryList)) {
      $fields = $Model::getFields($queryList['fields']);

      $this->response->sendOutput($fields);
    }
  }

  function massOperations()
  {
    $queryResult = parent::massOperations();
    if (!$queryResult) {
      return $this->response->withStatus(404);
    }
    $this->response->sendOutput($queryResult);
  }
}