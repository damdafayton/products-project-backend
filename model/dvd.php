<?php
class Dvd extends Product
{
  use Size;
  use ChildMethods;
  private $privateFields = ['size'];
  private $privateFieldDataTypes = 'i';
}