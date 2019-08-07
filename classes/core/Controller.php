<?php

namespace MWAETC\Core;

abstract class Controller {
  public function __construct() {

  }

  abstract function execute();

  abstract function render($vars = array());
}
