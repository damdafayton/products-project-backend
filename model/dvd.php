<?php
class Dvd extends Product
{
  private const CHILD_TABLE = 'dvds';
  use Size;
  use ChildMethods;
  private $privateFieldDataTypes = 'si';
}