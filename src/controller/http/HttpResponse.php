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
    return clone $this->setHeader($name, $value);
  }

  function setStatus($code = 200, $reasonPhrase = '')
  {
    header("HTTP/1.1 $code $reasonPhrase");
  }

  function withStatus($code = 200, $reasonPhrase = '')
  {
    return clone $this->setStatus($code = 200, $reasonPhrase = '');
  }

  /**
   * Send API output.
   *
   * @param mixed  $data
   * @param string $httpHeader
   */
  function sendOutput($data = null)
  {
    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode($data);

    exit;
  }
}