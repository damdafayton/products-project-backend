<?php

namespace controllers;

use utils;

abstract class BaseController
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

  protected function index()
  {
    $model = utils\controllerNameToModelName($this, __NAMESPACE__);

    $queryResult = $model::all();

    return $queryResult;
  }

  protected function show($id)
  {
    $model = utils\controllerNameToModelName($this, __NAMESPACE__);

    $instance = $model::getById($id);

    return $instance;
  }

  protected function massOperations($command)
  {
    $string = file_get_contents("php://input");

    if ($string === false) {
      return $this->exit("Send data in JSON format.");
    }

    $json = json_decode($string, true);

    if (!$json) {
      return $this->exit("Send some data");
    }

    ['list' => $list] = $json;

    $model = utils\controllerNameToModelName($this, __NAMESPACE__);

    return $model::$command(json_decode($list));
  }
}
