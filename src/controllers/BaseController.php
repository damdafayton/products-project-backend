<?php

namespace controllers;

use utils;

abstract class BaseController implements \Psr\Http\Message\ServerRequestInterface
{
  /**
   * __call magic method.
   */
  public function __call($name, $arguments)
  {
    $this->sendOutput(
      ["caller" => $name, "error" => $arguments],
      array('HTTP/1.1 404 Not Found')
    );
  }

  /**
   * Send API output.
   *
   * @param mixed  $data
   * @param string $httpHeader
   */
  protected function sendOutput($data, $httpHeaders = array())
  {
    header_remove('Set-Cookie');
    header("Content-Type: application/json; charset=UTF-8");

    if (is_array($httpHeaders) && count($httpHeaders)) {
      foreach ($httpHeaders as $httpHeader) {
        header($httpHeader);
      }
    }

    echo json_encode($data);

    exit;
  }

  // static function fromGlobals()
  // {
  // }

  /**
   * Get URI elements.
   * 
   * @return array
   */
  static function getUriSegmentList()
  {
    $uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // /test-scandiweb-products/index.php/api/products
    $uriSegmentList = explode('/', $uriPath); // [ , test-scandiweb-products, index.php, api, products]

    return $uriSegmentList;
  }

  /**
   * Get querystring params.
   * 
   * @return array
   */
  static function getQueryStringParams()
  {
    parse_str($_SERVER['QUERY_STRING'], $queryList);
    return $queryList;
  }

  protected function parseJSON()
  {
    $string = file_get_contents("php://input");

    if ($string === false) {
      return $this->exit("Send data in JSON format.");
    }

    $json = json_decode($string, true);

    if (!$json) {
      return $this->exit("Data is missing.");
    }

    return $json;
  }

  protected function index()
  {
    $model = utils\controllerNameToModelName($this, __NAMESPACE__);

    return $model::all();
  }

  protected function show($id)
  {
    $model = utils\controllerNameToModelName($this, __NAMESPACE__);

    return $model::getById($id);
  }

  protected function massOperations($massCommand)
  {
    $json = $this->parseJSON();

    $model = utils\controllerNameToModelName($this, __NAMESPACE__);
    $command  = utils\massCommandToSingularCommand($massCommand);

    if (!method_exists($model, $command)) {
      return $this->exit("Mass operation is not available.");
    }

    ['list' => $list] = $json;
    $list = json_decode($list);

    $response = null;

    foreach ($list as $item) {
      $response = $model::$command($item);
    }

    return $response;
  }
}