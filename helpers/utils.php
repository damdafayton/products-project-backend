<?php
function tableToClassName($tableName)
{
  $ModelClassFormat = ucwords((strtolower(substr($tableName, 0, strlen($tableName) - 1)))); // Book
  return $ModelClassFormat;
}

function thisToTableName($thisClass)
{
  return strtolower((new \ReflectionClass($thisClass))->getShortName()) . 's';
}

function classToTableName($class)
{
  return strtolower($class) . 's';
}