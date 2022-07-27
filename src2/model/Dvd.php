<?php

namespace model;

class Dvd extends Product
{
  use traits\Size;
  use traits\ChildMethods;
  private $privateFields = ['size'];
  private $privateFieldDataTypes = 'i';
}