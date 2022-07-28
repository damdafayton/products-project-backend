<?php
define("PROJECT_ROOT_PATH", dirname(dirname(__FILE__))); // Start from ../
// Import configuration settings
require_once PROJECT_ROOT_PATH . "/config/configuration.php";
// Import helper functions
require_once PROJECT_ROOT_PATH . "/helpers/utils.php";
require_once PROJECT_ROOT_PATH . "/helpers/product.php";

/* This auto loader will match class name to file path.
* Hence class name-spaces must have the same structure with their file paths.
* This is technically not necessary but,
* using this method makes it easier to locate class files by their namespace
*/
function autoLoader($className)
{
  $fileName = PROJECT_ROOT_PATH . '\\' . $className . ".php";
  $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);
  // echo $fileName . '___________';
  if (is_readable($fileName)) {
    require $fileName;
  }
}

spl_autoload_register('autoLoader');