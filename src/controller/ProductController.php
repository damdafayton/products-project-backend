<?php

namespace controller;

use utils;

class ProductController extends BaseController implements interfaces\ControllerInterface
{
  function index($req, $res)
  {
    $allProducts = parent::index($req, $res);
    // print_r($allProducts);
    $getPrivateFields = function ($product) {
      $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);
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

    return $res->sendOutput(array_map($getPrivateFields, $allProducts));
  }

  function show($req, $res)
  {
    $queryResult = parent::show($req, $res);

    // If product is found
    if ($queryResult['product_id'] > 0) {
      $category = $queryResult['category'];

      $Model = utils\tableNameToModelName($category, 'model');

      $modelInstance = new $Model($queryResult);

      return $res->sendOutput($modelInstance->getAttributes());
    } else {
      $this->exit('Id not found');
    }
  }

  function create($req, $res)
  {
    try {
      $body = $req->getParsedBody();
      if (!$body) {
        return $this->exit("Data is missing or corrupt.");
      }

      ['category' => $category] = $body;

      $model = utils\tableNameToModelName($category, 'model');

      if (class_exists($model)) {
        $instance = new $model($body);
        $result = $instance->create();

        $res->withStatus(201)->sendOutput($result);
      } else {
        $this->exit("Missing data!");
      }
    } catch (\Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function handleQueries($req, $res)
  {
    $Model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);
    // substr(get_class($this), 0, -10); // ProductController to Product
    $queryList = $req->getQueryParams();

    if (array_key_exists('fields', $queryList)) {
      $fields = $Model::getFields($queryList['fields']);

      $res->sendOutput($fields);
    }
  }

  function massOperations($req, $res)
  {
    $queryResult = parent::massOperations($req, $res);
    if (!$queryResult) {
      return $res->withStatus(404);
    }
    $res->withStatus(202)->sendOutput($queryResult);
  }
}