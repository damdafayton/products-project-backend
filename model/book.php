<?php
class Book extends Product
{
  use Weight;
  use ChildMethods;
  private $privateFields = ['weight'];
  private $privateFieldDataTypes = 's';
}