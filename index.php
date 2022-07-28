<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once dirname(__FILE__) . "/src/config/bootstrap.php";

$app = new controller\BaseController();

$req = new controller\http\HttpRequest();
$res = new controller\http\HttpResponse();

$method =  strtolower($req->getMethod());

$app->$method($req, $res);