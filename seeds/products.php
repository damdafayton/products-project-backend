<?php
require_once 'seedingModel.php ';
require_once 'productQueries.php';

$db = new Seeding();

$db->executeListOfMultipleQueries($productInsertQueries);