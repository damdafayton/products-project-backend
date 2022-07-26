<?php
class BaseController
{
  /**
   * __call magic method.
   */
  public function __call($name, $arguments)
  {
    $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
  }

  /**
   * Get URI elements.
   * 
   * @return array
   */
  function getUriSegmentList()
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
  function getQueryStringParams()
  {
    parse_str($_SERVER['QUERY_STRING'], $queryList);
    return $queryList;
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

  function index()
  {
    $Model = substr(get_class($this), 0, -10); // ProductController to Product
    $queryResult = $Model::all();

    $this->sendOutput($queryResult);
  }

  function show($id)
  {
    $Model = substr(get_class($this), 0, -10); // ProductController to Product
    $instance = $Model::getById($id);

    return $instance;
  }

  function massOperations($command)
  {
    $string = file_get_contents("php://input");
    if ($string === false) {
      $this->sendOutput(["error" => "Send data in JSON format."]);
    }
    $json = json_decode($string, true);
    ['list' => $list] = $json;

    $Model = substr(get_class($this), 0, -10); // ProductController to Product

    $result = $Model::$command(json_decode($list));
    // print_r($result);
    $this->sendOutput($result);
  }
}