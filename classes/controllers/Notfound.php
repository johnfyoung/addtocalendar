<?php

namespace MWAETC\Controllers;

use MWAETC\Core\Controller;

class Notfound extends Controller {
  public function __construct() {
    parent::__construct();
  }

  public function execute() {
    $this->render();
  }

  public function render($vars = array()) {
    echo "This calendar is not supported";
  }
}
