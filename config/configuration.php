<?php

$isServerRunninngOnLocal = $_SERVER['SERVER_NAME'] == 'localhost';
define("RUNNING_ON_LOCAL", $isServerRunninngOnLocal);

define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE_NAME", "test_scandiweb_products");

// define("DB_HOST", "us-cdbr-east-06.cleardb.net");
// define("DB_USERNAME", "b5c65dcef23a4c");
// define("DB_PASSWORD", "55e8369f");
// define("DB_DATABASE_NAME", "heroku_37d1f22892a0b4d");

// putenv('CLEARDB_DATABASE_URL=mysql://b5c65dcef23a4c:55e8369f@us-cdbr-east-06.cleardb.net/heroku_37d1f22892a0b4d?reconnect=true');