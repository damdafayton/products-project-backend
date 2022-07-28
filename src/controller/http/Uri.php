<?php

namespace controller\http;

class Uri implements \controller\interfaces\CustomPsrUriInterface
{
  protected $path;
  protected $query;

  function __construct()
  {
    $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // /test-scandiweb-products/index.php/api/products
    $this->query = $_SERVER['QUERY_STRING'];
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getQuery()
  {
    return $this->query;
  }
}