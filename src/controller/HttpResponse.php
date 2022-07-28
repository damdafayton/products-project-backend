<?php

namespace controller;

class HttpResponse implements interfaces\CustomPsrHttpResponseInterface
{
  protected $data;

  public function withHeader($name, $value)
  {
    header("$name: $value");
    return clone $this;
  }

  public function withStatus($code = 200, $reasonPhrase = '')
  {
    header("HTTP/1.1 $code $reasonPhrase");
    return clone $this;
  }

  public function setData($data)
  {
    $this->data = $data;
    return clone $this;
  }

  /**
   * Send API output.
   *
   * @param mixed  $data
   * @param string $httpHeader
   */
  public function sendOutput($data = null)
  {
    header("Content-Type: application/json; charset=UTF-8");

    if ($data) {
      $this->setData($data);
    }

    echo json_encode($this->data);

    exit;
  }
}