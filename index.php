<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once dirname(__FILE__) . "/config/bootstrap.php";

$baseController = new BaseController();

$uriSegmentList = $baseController->getUriSegmentList();
$targetPathOffset = 3; // /test-scandiweb-products/index.php/api
$Class = null;
$id = null;
$query = $_SERVER['QUERY_STRING'];
// echo $query;

// Deconstruct path
if (isset($uriSegmentList[$targetPathOffset + 1]) && $uriSegmentList[$targetPathOffset + 1]) {
  if (isset($uriSegmentList[$targetPathOffset + 2]) && $uriSegmentList[$targetPathOffset + 2]) {
    $id = $uriSegmentList[$targetPathOffset + 2];
  }

  $explodePathList = explode(':', $uriSegmentList[$targetPathOffset + 1]); // ['products, 'massDelete']

  $mainPath = $explodePathList[0]; // products || pRoDucTS
  $command = isset($explodePathList[1]) ? $explodePathList[1] : null;
  $Class = ucwords(strtolower(($mainPath))); // Products
  $Class = substr($Class, 0, strlen($Class) - 1); // Product

  $DynamicController = $Class . 'Controller'; // ProductController
}

// Check if we have the corresponding Model and Contoller Classes
if (class_exists($Class) && class_exists($DynamicController)) {
  $instance = new $DynamicController();
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      if ($id) {
        $instance->show($id);
      } else if ($query) {
        $instance->handleQueries();
      } else {
        $instance->index();
      }
      break;
    case 'POST':
      if ($command) { // Check for mass operations
        $instance->massOperations($command);
        break;
      };
      $instance->create();
      break;
      // case 'PUT':
      //   $instance->edit();
      //   break;
      // case 'DELETE':
      //   $instance->destroy();
      //   break;
    default:
      $instance->noAction();
  };
} else {
  header("HTTP/1.1 404 Not Found");
  exit();
}