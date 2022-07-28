<?php

namespace controller\interfaces;

interface ControllerInterface
{
  function index($req, $res);

  function show($req, $res);

  function massOperations($req, $res);
}