<?php
define("PROJECT_ROOT_PATH", dirname(dirname(__FILE__))); // Start from ../
// Import configuration settings
require_once PROJECT_ROOT_PATH . "/config/configuration.php";
// Import helpers
require_once PROJECT_ROOT_PATH . "/helpers/utils.php";

function autoLoader($className)
{
  $fileName = PROJECT_ROOT_PATH . '\\' . $className . ".php";
  $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);
  echo $fileName;
  echo "______________\r\n";
  if (is_readable($fileName)) {
    require $fileName;
  }
}

spl_autoload_register('autoLoader');