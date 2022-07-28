<?php

$isServerRunninngOnLocal = $_SERVER['SERVER_NAME'] == 'localhost';
define("RUNNING_ON_LOCAL", $isServerRunninngOnLocal);

const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_DATABASE_NAME = "test_scandiweb_products";