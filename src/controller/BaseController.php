<?php

namespace controller;

use utils;

const CONTROLLER_NAMESPACE = __NAMESPACE__;

class BaseController extends HttpRequest implements interfaces\ControllerInterface
{

  function index()
  {
    $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);

    return $model::all();
  }

  function show()
  {
    $id = $this->getPathId();

    $model = utils\controllerNameToModelName($this, CONTROLLER_NAMESPACE);

    return $model::getById($id);
  }

  function massOperations()
  {
    $massCommand = $this->getCustomMethod();

    $body = $this->getParsedBody();

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