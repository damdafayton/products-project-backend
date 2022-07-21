<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// include main configuration file
require_once PROJECT_ROOT_PATH . "/config/configuration.php";

// include the base controller file
// require_once PROJECT_ROOT_PATH . "/controllers/baseController.php";
require_once PROJECT_ROOT_PATH . "/controllers/productController.php";

// include the model files
require_once PROJECT_ROOT_PATH . '/model/traits/traitParentMethods.php';
require_once PROJECT_ROOT_PATH . '/model/traits/traitWeight.php';
require_once PROJECT_ROOT_PATH . '/model/traits/traitSize.php';
require_once PROJECT_ROOT_PATH . '/model/traits/traitDimensions.php';
require_once PROJECT_ROOT_PATH . '/model/traits/traitChildMethods.php';
require_once PROJECT_ROOT_PATH . "/model/product.php";
require_once PROJECT_ROOT_PATH . "/model/book.php";
require_once PROJECT_ROOT_PATH . "/model/dvd.php";
require_once PROJECT_ROOT_PATH . "/model/furniture.php";

// helpers
require_once PROJECT_ROOT_PATH . "/helpers/utils.php";