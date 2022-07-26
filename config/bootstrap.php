<?php
define("PROJECT_ROOT_PATH", dirname(dirname(__FILE__)));

echo 'HELLO2';

echo PROJECT_ROOT_PATH;

// // include main configuration file
require_once PROJECT_ROOT_PATH . "/config/configuration.php";

// // helpers
// require_once PROJECT_ROOT_PATH . "/helpers/utils.php";

// // include the model files
// require_once PROJECT_ROOT_PATH . '/model/database.php';
// require_once PROJECT_ROOT_PATH . '/model/traits/weight.php';
// require_once PROJECT_ROOT_PATH . '/model/traits/size.php';
// require_once PROJECT_ROOT_PATH . '/model/traits/dimensions.php';
// require_once PROJECT_ROOT_PATH . '/model/traits/childMethods.php';
// require_once PROJECT_ROOT_PATH . "/model/product.php";
// require_once PROJECT_ROOT_PATH . "/model/book.php";
// require_once PROJECT_ROOT_PATH . "/model/dvd.php";
// require_once PROJECT_ROOT_PATH . "/model/furniture.php";

// // include the base controller file
// require_once PROJECT_ROOT_PATH . "/controllers/baseController.php";
// require_once PROJECT_ROOT_PATH . "/controllers/productController.php";