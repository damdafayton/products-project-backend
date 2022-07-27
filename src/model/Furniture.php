<?php

namespace model;

class Furniture extends Product
{
  use traits\Dimensions;

  use traits\ProductChildMethods;

  private $privateFields = ['height', 'width', 'length'];
  private $privateFieldDataTypes = 'iii';
}