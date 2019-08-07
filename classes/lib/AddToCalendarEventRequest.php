<?php
namespace MWAETC\Lib;

use HTMLPurifier;
use HTMLPurifier_Config;
use \Exception;
use \DateTimeZone;
use \DateTime;

/**
 * Class AddToCalendarEventRequest
 *
 * Processes the $_GET params from an Add to Calendar link
 *
 * Add to Calendar submits events as an array:
 * $_GET[$e]
 *
 * @package MWAETC\Lib
 * @see https://addtocalendar.com
 */
class AddToCalendarEventRequest {
  protected $_events = array();

  /**
   * AddToCalendarEventRequest constructor.
   * @throws Exception
   */
  public function __construct() {
    if(!empty($_GET["e"])) {
      $this->_processRequest($_GET["e"]);
    } else {
      throw new Exception("No events found in this request");
    }
  }

  /**
   * Get the event from the request
   *
   * @param int $index
   * @return array|mixed
   */
  public function getEvent($index = -1) {
    if($index > -1) {
      return $this->_events[$index];
    } else {
      return $this->_events;
    }
  }

  /**
   * Get the count of events from this request
   *
   * @return int|void
   */
  public function count() {
    return count($this->_events);
  }

  /**
   * Process the Request, extract the event details and clean the input
   *
   * @param $events
   * @throws Exception
   */
  protected function _processRequest($events) {
    if(is_array($events)) {

      // use HTMLPurifier to prevent XSS
      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      foreach($events as $e) {
        $scrubbed = array();

        $scrubbed['title'] = $purifier->purify($e["title"]);

        $tz = new DateTimeZone($purifier->purify($e["timezone"]));
        $start = new DateTime($purifier->purify($e["date_start"]), $tz);
        $end = !empty($e["date_end"]) ? new DateTime($purifier->purify($e["date_end"]),$tz) : null;

        $scrubbed["timezone"] = $tz;
        $scrubbed["start"] = $start;
        $scrubbed["end"] = $end;
        $scrubbed['description'] = $purifier->purify($e["description"]);
        $scrubbed['text description'] = Html::html_to_text($scrubbed['description']);
        $scrubbed['location'] = $purifier->purify($e["location"]);
        $scrubbed['organizer_email'] = $purifier->purify($e["organizer_email"]);

        $this->_events[] = $scrubbed;
      }
    } else {
      throw new Exception("Expected event request to contain an array of events.");
    }
  }
}
