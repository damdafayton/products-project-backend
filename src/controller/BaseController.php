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
    $this->request = new HttpRequest();
    $this->response = new HttpResponse();
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
}