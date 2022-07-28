<?php

namespace controller;

use utils;

const CONTROLLER_NAMESPACE = __NAMESPACE__;

class BaseController implements interfaces\ControllerInterface
{
  public $request;
  public $response;

  function __construct()
  {
    $this->request = new http\HttpRequest();
    $this->response = new http\HttpResponse();
  }

  /**
   * __call magic method.
   */
  function __call($name, $arguments)
  {
    $this->response
      ->withStatus(404, "Not Found")
      ->sendOutput(["caller" => $name, "error" => $arguments]);
  }

  function index()
  {
    $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);

    return $model::all();
  }

  function show()
  {
    $id = $this->request->getPathId();

    $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);

    return $model::getById($id);
  }

  function massOperations()
  {
    $massCommand = $this->request->getCustomMethod();

    $body = $this->request->getParsedBody();

    if (!$body) {
      return $this->exit("Data is missing or corrupt.");
    }

    $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);
    $command  = utils\massCommandToSingularCommand($massCommand);

    if (!method_exists($model, $command)) {
      return $this->exit("Mass operation is not available.");
    }

    ['list' => $list] = $body;
    $list = json_decode($list);

    $response = null;

    foreach ($list as $item) {
      $response = $model::$command($item);
    }

    return $response;
  }

  function getControllerClassName()
  {
    $controllerPath = $this->request->getControllerPath();
    $controllerName = substr(ucwords(strtolower(($controllerPath))), 0, -1) . 'Controller';

    if ($controllerPath) {
      $controllerName = '\\' . CONTROLLER_NAMESPACE . '\\' . $controllerName;
    }

    return $controllerName;
  }

  function getController()
  {
    $controllerClass = $this->getControllerClassName();

    if (!class_exists($controllerClass)) {
      return $this->exit('Action not found');
    }

    return new $controllerClass();
  }

  function get()
  {
    $controllerInstance = $this->getController();

    $pathId = $this->request->getPathId();
    $query = $this->request->getUri()->getQuery();

    if ($pathId) {
      $controllerInstance->show();
    } else if ($query) {
      $controllerInstance->handleQueries();
    } else {
      $controllerInstance->index();
    }
  }

  function post()
  {
    $controllerInstance = $this->getController();

    $customMethod = $this->request->getCustomMethod();

    // Check for batch operations
    if ($customMethod) {
      $controllerInstance->massOperations();
    } else {
      $controllerInstance->create();
    }
  }
}