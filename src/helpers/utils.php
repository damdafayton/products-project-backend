<?php

namespace utils;

function massCommandToSingularCommand($massCommand)
{
  $command = str_replace('mass', '', $massCommand);
  return strtolower($command);
}

function removeNameSpace($string, $namespace)
{
  return str_replace($namespace . '\\', '', $string);
}

function controllerNameToModelName($thisOfController, $namespace = null)
{
  // ProductController to Product
  // controller\ProductController to model\Product

  $modelClass = substr(get_class($thisOfController), 0, -10);

  if ($namespace) {
    $modelClass = 'model\\' . removeNameSpace($modelClass, $namespace);
  }

  return $modelClass;
}

function modelNameToTableName($classOfModel, $namespace = null)
{
  // model\Product to products

  $tableName = strtolower($classOfModel) . 's';

  if ($namespace) {
    $tableName = removeNameSpace($tableName, $namespace);
  }

  return $tableName;
}

function tableNameToModelName($tableName, $namespace = null)
{
  // books to model\Book

  $model = ucwords((strtolower(substr($tableName, 0, strlen($tableName) - 1))));

  if ($namespace) {
    $model = $namespace . '\\' . $model;
  }

  return $model;
}