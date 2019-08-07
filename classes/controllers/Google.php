<?php

namespace MWAETC\Controllers;

use MWAETC\Core\Controller;
use MWAETC\Lib\AddToCalendarEventRequest;
use MWAETC\Lib\Html;

class Google extends Controller {
  public function __construct() {
    parent::__construct();
  }

  public function execute() {
    $request = new AddToCalendarEventRequest();

    if($request->count() > 0) {
      // here is an example
      //https://calendar.google.com/calendar/r/eventedit?&dates=20190723T080000/20190723T090000&ctz=America/Los_Angeles&details=Thank+you+for+registering!%0A%0AYou+will+receive+an+email+shortly+with+this+information:%3Cbr+/%3E%26nbsp;%0A%0ABefore+8+am+Pacific,+click+on+https://washington.zoom.us/j/348397923+(https://washington.zoom.us/j/348397923).+Please+enter+your+name+and+your+email+address.+If+you+haven%26%2339;t+used+Zoom+before,+allow+a+minute+or+two+to+download+Zoom.%3Cbr+/%3E%26nbsp;%0A%0AYour+feedback+is+important+to+us.+Please+complete+the+evaluation+(https://mwaetc.org/evaluation/evaluation2.html?ER_ID%3D37942%26amp;Ev_Type%3D3)+after+the+event.+For+nurses+or+others+who+requested+CE,+one+CNE+contact+hour+or+one+CE+is+available+if+you+complete+the+evaluation+before+Friday,+July+26+at+3+pm+Pacific+Time.%26nbsp;%0A%0AThe+recorded+webinar+will+be+available+at+the+MWAETC+website:+https://mwaetc.org/training/aids-clinical-conference+(http://mwaetc.org/training/aids-clinical-conference).%3Cbr+/%3E%26nbsp;%0A%0AVisit+Your+Dashboard+for+additional+information:https://mwaetc.org/participant-dashboard/event-details/?ER_ID%3D37942%0A%0A--%0Ahttp://go.addtocalendar.com&location=908+Jefferson+Street,+13th+Floor,+Room+1360+Ninth+and+Jefferson+Building+(NJB)+Seattle,%0AWA,+98104&pli=1&uid=1563582418addtocalendar&sf=true&output=xml
      //https://calendar.google.com/calendar/r/eventedit?text=ACC:+HIV+in+Neglected+Communities:+The+Intersection+of+Homelessness,+IDU+and+Transactional+Sex&dates=20190723PDT080000/20190723PDT090000&ctx=America/Los_Angeles&details=Thank+you+for+registering!%5Cn%5CnYou+will+receive+an+email+shortly+with+this+information:%5Cn%5CnBefore+8+am+Pacific,+click+on+https://washington.zoom.us/j/348397923+(https://washington.zoom.us/j/348397923).+Please+enter+your+name+and+your+email+address.+If+you+haven%27t+used+Zoom+before,+allow+a+minute+or+two+to+download+Zoom.%5Cn%5CnYour+feedback+is+important+to+us.+Please+complete+the+evaluation+(https://mwaetc.org/evaluation/evaluation2.html?ER_ID%3D37942%26Ev_Type%3D3)+after+the+event.+For+nurses+or+others+who+requested+CE,+one+CNE+contact+hour+or+one+CE+is+available+if+you+complete+the+evaluation+before+Friday,+July+26+at+3+pm+Pacific+Time.%5Cn%5CnThe+recorded+webinar+will+be+available+at+the+MWAETC+website:+https://mwaetc.org/training/aids-clinical-conference+(http://mwaetc.org/training/aids-clinical-conference).%5Cn%5CnVisit+Your+Dashboard+for+additional+information:https://mwaetc.org/participant-dashboard/event-details/?ER_ID%3D37942&location=908+Jefferson+Street,+13th+Floor,+Room+1360+Ninth+and+Jefferson+Building+(NJB)+Seattle,%0A+WA,+98104&pli=1&uid=2019-07-22-20-27-11@mwaetc.org&sf=true&output=xml

      // text=ACC:+HIV+in+Neglected+Communities:+The+Intersection+of+Homelessness,+IDU+and+Transactional+Sex
      // dates=20190723T080000/20190723T090000
      // ctz=America/Los_Angeles
      // details=Thank+you+for+registering!%0A%0AYou+will+receive+an+email+shortly+with+this+information:%3Cbr+/%3E%26nbsp;%0A%0ABefore+8+am+Pacific,+click+on+https://washington.zoom.us/j/348397923+(https://washington.zoom.us/j/348397923).+Please+enter+your+name+and+your+email+address.+If+you+haven%26%2339;t+used+Zoom+before,+allow+a+minute+or+two+to+download+Zoom.%3Cbr+/%3E%26nbsp;%0A%0AYour+feedback+is+important+to+us.+Please+complete+the+evaluation+(https://mwaetc.org/evaluation/evaluation2.html?ER_ID%3D37942%26amp;Ev_Type%3D3)+after+the+event.+For+nurses+or+others+who+requested+CE,+one+CNE+contact+hour+or+one+CE+is+available+if+you+complete+the+evaluation+before+Friday,+July+26+at+3+pm+Pacific+Time.%26nbsp;%0A%0AThe+recorded+webinar+will+be+available+at+the+MWAETC+website:+https://mwaetc.org/training/aids-clinical-conference+(http://mwaetc.org/training/aids-clinical-conference).%3Cbr+/%3E%26nbsp;%0A%0AVisit+Your+Dashboard+for+additional+information:https://mwaetc.org/participant-dashboard/event-details/?ER_ID%3D37942%0A%0A--%0Ahttp://go.addtocalendar.com
      // location=908+Jefferson+Street,+13th+Floor,+Room+1360+Ninth+and+Jefferson+Building+(NJB)+Seattle,%0AWA,+98104
      // pli=1
      // uid=1563582418addtocalendar
      // sf=true
      // output=xml

      // this will only work for one event
      $e = $request->getEvent(0);

      $params = array(
        "text" => $e['title'],
        "dates" => $this->_setDates($e["start"], $e["end"]),
        "ctx" => $e["timezone"]->getName(),
        "details" => $e["text description"],
        "location" => $e["location"],
        "pli" => "1",
        "uid" => date('Y-m-d-H-i-s') . "@mwaetc.org",
        "sf" => "true",
        "output" => "xml"
      );

    } else {
      $params = "No invitation parameters provided";
    }

    $this->render(array("params" => $params));
  }

  protected function _setDates($start, $end = null) {
    $format_date = "Ymd";
    $format_time = "His";
    $start_str = $start->format($format_date) ."T". $start->format($format_time);
    $end = !empty($end) ? $end : (clone $start)->modify("+1 hour");
    $end_str = $end->format($format_date) ."T". $end->format($format_time);
    return sprintf("%s/%s", $start_str, $end_str);
  }

  public function render($vars = array()) {
    header("Location: https://calendar.google.com/calendar/r/eventedit?". http_build_query($vars["params"]));
    exit();
  }
}
