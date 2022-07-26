<?php

namespace controller\http;

class HttpRequest implements \controller\interfaces\CustomPsrHttpRequestInterface
{
  protected $requestMethod;
  protected $uri;
  protected $apiNameSpacePath;

  function __construct()
  {
    $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    $this->uri = new Uri();
    // Remote server =  /test-scandiweb-products/index.php/api = 3 
    // Local server = /index.php/api = 2
    $this->apiNameSpacePath = RUNNING_ON_LOCAL ? 3 : 2;
  }

  /**
   * Get URI elements.
   * 
   * @return array
   */
  function getUriSegmentList()
  {
    return explode('/', $this->getUri()->getPath()); // [ , test-scandiweb-products, index.php, api, products:massOperation]
  }

  function getControllerPath()
  {
    $uriSegmentList = $this->getUriSegmentList();
    $lastPathExpoded = explode(':', $uriSegmentList[$this->apiNameSpacePath + 1]); // ['products, 'massOperation']
    return $lastPathExpoded[0];
  }

  function getCustomMethod()
  {
    $uriSegmentList = $this->getUriSegmentList();
    $lastPathExpoded = explode(':', $uriSegmentList[count($uriSegmentList) - 1]); // ['products, 'massOperation']

    return isset($lastPathExpoded[1]) ? $lastPathExpoded[1] : null;
  }

  function getPathId()
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

  function getMethod()
  {
    return $this->requestMethod;
  }

  function getUri()
  {
    return $this->uri;
  }

  function getQueryParams()
  {
    parse_str($this->getUri()->getQuery(), $queryList);
    return $queryList;
  }

  function getParsedBody()
  {
    // We are only parsing JSON posts for now

    $string = file_get_contents("php://input");

    if ($string === false) {
      return null;
    }

    $json = json_decode($string, true);

    if (!$json) {
      return null;
    }

    return $json;
  }
}