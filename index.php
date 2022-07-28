<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once dirname(__FILE__) . "/src/config/bootstrap.php";

$app = new controller\BaseController();
$request = $app->request;
$response = $app->response;

$method =  strtolower($request->getMethod());

$app->$method();