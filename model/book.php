<?php
class Book extends Product
{
  private const CHILD_TABLE = 'books';
  use Weight;
  use ChildMethods;
  private $privateFieldDataTypes = 'ss';
}