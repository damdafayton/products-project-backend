<?php

namespace controller;

use utils;

class BaseController extends HttpRequest
{
  protected $apiNameSpacePath;
  public $response;

  function __construct()
  {
    parent::__construct();
    // Remote server =  /test-scandiweb-products/index.php/api = 3 
    // Local server = /index.php/api = 2
    $this->apiNameSpacePath = RUNNING_ON_LOCAL ? 3 : 2;

    $this->response = new HttpResponse();
  }
  /**
   * __call magic method.
   */
  public function __call($name, $arguments)
  {

    $this->response
      ->withStatus(404, "Not Found")
      ->sendOutput(["caller" => $name, "error" => $arguments]);
  }

  /**
   * Get URI elements.
   * 
   * @return array
   */
  public function getUriSegmentList()
  {
    return explode('/', $this->getUri()->getPath()); // [ , test-scandiweb-products, index.php, api, products:massOperation]
  }

  public function getControllerPath()
  {
    $uriSegmentList = $this->getUriSegmentList();
    $lastPathExpoded = explode(':', $uriSegmentList[$this->apiNameSpacePath + 1]); // ['products, 'massOperation']
    return $lastPathExpoded[0];
  }

  public function getControllerClassName()
  {
    $controllerPath = $this->getControllerPath();
    return '\\controller\\' . substr(ucwords(strtolower(($controllerPath))), 0, -1) . 'Controller';
  }

  public function getCustomMethod()
  {
    $uriSegmentList = $this->getUriSegmentList();
    $lastPathExpoded = explode(':', $uriSegmentList[count($uriSegmentList) - 1]); // ['products, 'massOperation']

    return isset($lastPathExpoded[1]) ? $lastPathExpoded[1] : null;
  }

  public function getPathId()
  {
    $id = null;
    $apiPath = $this->apiNameSpacePath;
    $uriSegmentList = $this->getUriSegmentList();

    if (isset($uriSegmentList[$apiPath + 2])) {
      $id;
      $id = $uriSegmentList[$apiPath + 2];
    }

    return is_numeric($id) ? $id : null;
  }

  protected function index()
  {
    $model = utils\controllerNameToModelName($this, __NAMESPACE__);

    return $model::all();
  }

  protected function show()
  {
    $id = $this->getPathId();

    $model = utils\controllerNameToModelName($this, __NAMESPACE__);

    return $model::getById($id);
  }

  protected function massOperations()
  {
    $massCommand = $this->getCustomMethod();

    $body = $this->getParsedBody();

    $model = utils\controllerNameToModelName($this, __NAMESPACE__);
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