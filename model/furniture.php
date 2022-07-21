<?php
class Furniture extends Product
{
  use Dimensions;
  use ChildMethods;
  private $privateFields = ['height', 'width', 'length'];
  private $privateFieldDataTypes = 'iii';
}