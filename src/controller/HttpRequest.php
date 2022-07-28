<?php

namespace controller;

abstract class HttpRequest implements interfaces\CustomPsrHttpRequestInterface
{

  public $response;
  protected $requestMethod;
  protected $uri;

  function __construct()
  {
    $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    $this->uri = new Uri();
  }

  public function getMethod()
  {
    return $this->requestMethod;
  }

  public function getUri()
  {
    return $this->uri;
  }

  public function getQueryParams()
  {
    parse_str($this->getUri()->getQuery(), $queryList);
    return $queryList;
  }

  public function getParsedBody()
  {
    // We are only parsing JSON posts for now

    $string = file_get_contents("php://input");

    if ($string === false) {
      return $this->response->withStatus(404, "Send data in JSON format.");
    }

    $json = json_decode($string, true);

    if (!$json) {
      return $this->response->withStatus(404, "Data is missing.");
    }

    return $json;
  }
}