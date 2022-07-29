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
    $allowedClient = CORS_ALLLOWED_CLIENT;
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: ${allowedClient}");

    echo json_encode($data);

    exit;
  }
}