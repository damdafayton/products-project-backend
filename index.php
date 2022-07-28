<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once dirname(__FILE__) . "/src/config/bootstrap.php";

$base = new controller\BaseController();
$request = $base->request;
$response = $base->response;

$query = $request->getUri()->getQuery();
$customMethod = $request->getCustomMethod();
$controllerClass = $request->getControllerClassName();
$pathId = $request->getPathId();

// If there is a Contoller Class for the request continue
if (class_exists($controllerClass)) {
  $instance = new $controllerClass();
  switch ($request->getMethod()) {
    case 'GET':
      if ($pathId) {
        $instance->show();
      } else if ($query) {
        $instance->handleQueries();
      } else {
        $instance->index();
      }
      break;
    case 'POST':
      if ($customMethod) { // Check for batch operations
        $instance->massOperations();
        break;
      };
      $instance->create();
      break;
    default:
      $instance->exit('Action couldn\'t found');
  };
} else {
  $response->withStatus(404, "Not Found");
}