<?php
trait ChildMethods
{
  function __construct($sqlResponse)
  {
    parent::__construct($sqlResponse);
    try {
      foreach ($this->privateFields as $field) {
        $this->$field = $sqlResponse[$field];
      }
    } catch (Exception $e) {
      // throw new Exception($e->getMessage());
    }
  }

  function getAttributes()
  {
    $attributes = parent::getAttributes();
    foreach ($this->privateFields as $field) {
      $attributes[$field] = $this->$field;
    }
    return $attributes;
  }
}