<?php

namespace model;

class Book extends Product
{
  use traits\Weight;
  use traits\ChildMethods;
  private $privateFields = ['weight'];
  private $privateFieldDataTypes = 's';
}