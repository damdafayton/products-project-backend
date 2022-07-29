<?php

namespace controller\http;

class HttpResponse implements \controller\interfaces\CustomPsrHttpResponseInterface
{
  function setHeader($name, $value)
  {
    header("$name: $value");
  }

  function withHeader($name, $value)
  {
    $clone = clone $this;
    $clone->setHeader($name, $value);
    return $clone;
  }

  function setStatus($code = 200, $reasonPhrase = '')
  {
    header("HTTP/1.1 $code $reasonPhrase");
  }

  function withStatus($code = 200, $reasonPhrase = '')
  {
    $clone = clone $this;
    $clone->setStatus($code = 200, $reasonPhrase = '');
    return $clone;
  }

  /**
   * Send API output.
   *
   * @param mixed  $data
   * @param string $httpHeader
   */
  function sendOutput($data = null)
  {
    $host = $_SERVER['HTTP_HOST'];

    if ($host == CORS_SERVER_CLIENT_PAIR[0]) {
      $uri = CORS_SERVER_CLIENT_PAIR[1];
      header("Access-Control-Allow-Origin: ${uri}");
    }

    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode($data);

    exit;
  }
}