<?php
require_once 'seedingModel.php ';
require_once './categoryQueries.php';

$db = new Seeding();
$db->executeListOfQueries($categoryCreateTableQueries);
$db->executeListOfMultipleQueries($categoryIndexQueries);
$db->executeListOfMultipleQueries($categoryInsertQueries);