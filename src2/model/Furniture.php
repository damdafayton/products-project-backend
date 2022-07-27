<?php

namespace model;

class Furniture extends Product
{
  use traits\Dimensions;
  use traits\ChildMethods;
  private $privateFields = ['height', 'width', 'length'];
  private $privateFieldDataTypes = 'iii';
}