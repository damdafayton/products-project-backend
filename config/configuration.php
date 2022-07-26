<?php

$isServerRunninngOnLocal = $_SERVER['SERVER_NAME'] == 'localhost';
define("RUNNING_ON_LOCAL", $isServerRunninngOnLocal);

define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE_NAME", "test_scandiweb_products");