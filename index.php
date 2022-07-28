<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once dirname(__FILE__) . "/src/config/bootstrap.php";

$uriSegmentList = controllers\BaseController::getUriSegmentList();
$apiPath = RUNNING_ON_LOCAL ? 3 : 2; // /test-scandiweb-products/index.php/api = 3  // /index.php/api = 2
$id = null;
$query = $_SERVER['QUERY_STRING'];

// Deconstruct path

if (isset($uriSegmentList[$apiPath + 1])) {
  $explodePathList = explode(':', $uriSegmentList[$apiPath + 1]); // ['products, 'massDelete']

  $mainPath = $explodePathList[0]; // products || pRoDucTS

  // products || pRoDucTS => ProductController
  $controller = '\\controllers\\' . substr(ucwords(strtolower(($mainPath))), 0, -1) . 'Controller';
  $command = isset($explodePathList[1]) ? $explodePathList[1] : null;
}

if (isset($uriSegmentList[$apiPath + 2])) {
  $id = $uriSegmentList[$apiPath + 2];
}

// Check if we have the corresponding Contoller Class
if (class_exists($controller)) {
  $instance = new $controller();
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