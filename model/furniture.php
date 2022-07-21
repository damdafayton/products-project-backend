<?php
class Furniture extends Product
{
  private const CHILD_TABLE = 'furnitures';
  use Dimensions;
  use ChildMethods;
  private $privateFieldDataTypes = 'siii';
}