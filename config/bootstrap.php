<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// include main configuration file
require_once PROJECT_ROOT_PATH . "/config/configuration.php";

// include the base controller file
// require_once PROJECT_ROOT_PATH . "/controllers/baseController.php";
require_once PROJECT_ROOT_PATH . "/controllers/productController.php";

// include the product model file
require_once PROJECT_ROOT_PATH . "/model/product.php";
require_once PROJECT_ROOT_PATH . "/model/book.php";