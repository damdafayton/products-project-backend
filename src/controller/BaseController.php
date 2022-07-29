<?php

/**
 * Base controller queries database and return the query result.
 * It doesnt send response unless request is unsuccessfull. 
 * In that case I use exit() method to fallback to __call().
 */

namespace controller;

use utils;

const CONTROLLER_NAMESPACE = __NAMESPACE__;

class BaseController implements interfaces\ControllerInterface
{
  /**
   * __call magic method.
   */
  function __call($name, $arguments)
  {
    $res = new http\HttpResponse();

    $res
      ->withStatus(404, "Not Found")
      ->sendOutput(["caller" => $name, "error" => $arguments]);
  }

  function index($req, $res)
  {
    $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);

    return $model::all();
  }

  function show($req, $res)
  {
    $id = $req->getPathId();

    $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);

    return $model::getById($id);
  }

  function massOperations($req, $res)
  {
    $massCommand = $req->getCustomMethod();

    $body = $req->getParsedBody();

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


  // Gets the path like /products or /users and returns ProductController or UserController string
  // @return string

  function getControllerClassName($req)
  {
    $controllerPath = $req->getControllerPath();

    $controllerName = substr(ucwords(strtolower(($controllerPath))), 0, -1) . 'Controller';

    if (CONTROLLER_NAMESPACE) {
      $controllerName = '\\' . CONTROLLER_NAMESPACE . '\\' . $controllerName;
    }

    return $controllerName;
  }

  // @return controller instance

  function getController($req)
  {
    $controllerClass = $this->getControllerClassName($req);

    if (!class_exists($controllerClass)) {
      return $this->exit('Action not found');
    }

    return new $controllerClass();
  }

  function get($req, $res)
  {
    $controllerInstance = $this->getController($req);

    $pathId = $req->getPathId();
    $query = $req->getUri()->getQuery();

    if ($pathId) {
      $controllerInstance->show($req, $res);
    } else if ($query) {
      $controllerInstance->handleQueries($req, $res);
    } else {
      $controllerInstance->index($req, $res);
    }
  }

  function post($req, $res)
  {
    $controllerInstance = $this->getController($req);

    $customMethod = $req->getCustomMethod();

    // Check for batch operations
    if ($customMethod) {
      $controllerInstance->massOperations($req, $res);
    } else {
      $controllerInstance->create($req, $res);
    }
  }
}