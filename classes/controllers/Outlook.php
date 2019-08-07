<?php

namespace MWAETC\Controllers;

use MWAETC\Core\Controller;
use MWAETC\Lib\AddToCalendarEventRequest;
use MWAETC\Lib\iCalGenerator;

class Outlook extends Controller {
  public function __construct() {
    parent::__construct();
  }

  public function execute() {
    if(!empty($_GET['e'])) {
      $request = new AddToCalendarEventRequest();
      $invite = iCalGenerator::create($request->getEvent());
    } else {
      $invite = "No invitation parameters provided";
    }

    $this->render(array("invite" => $invite));
  }

  public function render($vars = array()) {
    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename=event.ics');

    echo $vars["invite"];
  }
}
