<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once dirname(__FILE__) . "/config/bootstrap.php";

$baseController = new BaseController();

$uriSegmentList = $baseController->getUriSegmentList();
$apiPath = RUNNING_ON_LOCAL ? 3 : 2; // /test-scandiweb-products/index.php/api = 3  // /index.php/api = 2
$Class = null;
$id = null;
$query = $_SERVER['QUERY_STRING'];

// Deconstruct path
if (isset($uriSegmentList[$apiPath + 1]) && $uriSegmentList[$apiPath + 1]) {
  if (isset($uriSegmentList[$apiPath + 2]) && $uriSegmentList[$apiPath + 2]) {
    $id = $uriSegmentList[$apiPath + 2];
  }

  $explodePathList = explode(':', $uriSegmentList[$apiPath + 1]); // ['products, 'massDelete']

  $mainPath = $explodePathList[0]; // products || pRoDucTS
  $command = isset($explodePathList[1]) ? $explodePathList[1] : null;
  $Class = substr(ucwords(strtolower(($mainPath))), 0, -1); // Products => Product
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