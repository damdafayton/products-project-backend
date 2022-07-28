<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once dirname(__FILE__) . "/src/config/bootstrap.php";

$app = new controller\BaseController();

$method =  strtolower($app->request->getMethod());

$app->$method();