<?php
class PHPDebug
{

  function __construct()
  {
    if (!defined("LOG")) define("LOG", 1);
    if (!defined("INFO")) define("INFO", 2);
    if (!defined("WARN")) define("WARN", 3);
    if (!defined("ERROR")) define("ERROR", 4);

    define("NL", "\r\n");
    echo '';
    /// end of IE
  }
  function debug($name, $var = null, $type = LOG)
  {
    echo '' . NL;
  }
}