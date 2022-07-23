<?php
require __DIR__ . "/config/bootstrap.php";

$baseController = new BaseController();

$uriSegmentList = $baseController->getUriSegmentList();
$targetPathOffset = 3; // /test-scandiweb-products/index.php/api
$Class = null;
$id = null;

// Deconstruct path
if (isset($uriSegmentList[$targetPathOffset + 1]) && $uriSegmentList[$targetPathOffset + 1]) {
  if (isset($uriSegmentList[$targetPathOffset + 2]) && $uriSegmentList[$targetPathOffset + 2]) {
    $id = $uriSegmentList[$targetPathOffset + 2];
  }
  $commandPathList = explode(':', $uriSegmentList[$targetPathOffset + 1]); // ['products, 'massDelete']
  $mainPath = $commandPathList[0]; // products || pRoDucTS
  $command = isset($commandPathList[1]) ? $commandPathList[1] : null;
  $Class = ucwords(strtolower(($mainPath))); // Products
  $Class = substr($Class, 0, strlen($Class) - 1); // Product
  $DynamicController = $Class . 'Controller'; // ProductController
}
// Check if we have the corresponding contoller class
if (class_exists($Class) && class_exists($DynamicController)) {
  $instance = new $DynamicController();
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      if (!$id) {
        $instance->index();
      } else {
        $instance->show($id);
      }
      break;
    case 'POST':
      if ($command) { // Check for mass operations
        $instance->massOperations($Class, $command);
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