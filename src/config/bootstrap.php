<?php
define("PROJECT_ROOT_PATH", dirname(dirname(__FILE__))); // Start from ../
// Import configuration settings
require_once PROJECT_ROOT_PATH . "/config/configuration.php";
// Import helper functions
require_once PROJECT_ROOT_PATH . "/helpers/utils.php";
require_once PROJECT_ROOT_PATH . "/helpers/product.php";

/* 
* Register classes.
* This auto loader will match class name to file path.
* Hence class name-spaces must have the same structure with their file paths.
* This is technically not necessary but,
* using this method makes it easier to locate class files by their namespace
*/

spl_autoload_register(function ($className) {
  $fileName = PROJECT_ROOT_PATH . '\\' . $className . ".php";
  $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);
  // echo $fileName . '___________';
  if (is_readable($fileName)) {
    require $fileName;
  }
});

/**
 * Register interfaces.
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Psr\Http\Message\Interface 
 * from /path/to/project/src/interfaces/psr/Interface.php:
 *
 *      new \Psr\Http\Message\Interface;
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */

spl_autoload_register(function ($class) {

  // project-specific namespace prefix
  $prefix = 'Psr\\Http\\Message\\';

  // base directory for the namespace prefix
  $base_dir = PROJECT_ROOT_PATH . '\\interfaces\\psr\\';

  // does the class use the namespace prefix?
  $len = strlen($prefix);
  if (strncmp($prefix, $class, $len) !== 0) {
    // no, move to the next registered autoloader
    return;
  }

  // get the relative class name
  $relative_class = substr($class, $len);

  // replace the namespace prefix with the base directory, replace namespace
  // separators with directory separators in the relative class name, append
  // with .php
  $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

  // if the file exists, require it
  if (file_exists($file)) {
    require $file;
  }
});