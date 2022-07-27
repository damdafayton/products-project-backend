<?php

namespace model;

class Book extends Product
{
  use traits\Weight;

  use traits\ProductChildMethods;

  private $privateFields = ['weight'];
  private $privateFieldDataTypes = 's';
}