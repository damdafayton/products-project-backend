<?php

namespace model;

class Dvd extends Product
{
  use traits\Size;

  use traits\ProductChildMethods;

  private $privateFields = ['size'];
  private $privateFieldDataTypes = 'i';
}