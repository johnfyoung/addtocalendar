<?php
namespace MWAETC\Lib;
use \Liliumdev\ICalendar\ZCiCal as ZCiCal;
use \Liliumdev\ICalendar\ZCiCalNode as ZCiCalNode;
use \Liliumdev\ICalendar\ZCiCalDataNode as ZCiCalDataNode;
use \Liliumdev\ICalendar\ZDateHelper as ZDateHelper;

use MWAETC\Lib\Html;

class iCalGenerator {
  public static function create($event_list) {
    if(!empty($event_list)) {
      // create the ical object
      $icalobj = new \Liliumdev\ICalendar\ZCiCal();

      foreach($event_list as $index => $e){
        // create the event within the ical object
        $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);

        // add title
        $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . ZCiCal::formatContent($e["title"])));

        // add confirmned status to the meeting invite
        $eventobj->addNode(new ZCiCalDataNode("STATUS:CONFIRMED"));

        // add start date
        $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZDateHelper::toiCalDateTime($e["start"]->getTimestamp()) ."Z"));

        // add end date
        $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ($e["end"] !== null ? ZDateHelper::toiCalDateTime($e["end"]->getTimestamp()) : ZDateHelper::toiCalDateTime($e["start"]->getTimestamp()) ."Z")));

        // UID is a required item in VEVENT, create unique string for this event
        // Adding your domain to the end is a good way of creating uniqueness
        $uid = date('Y-m-d-H-i-s') . "@mwaetc.org";
        $eventobj->addNode(new ZCiCalDataNode("UID:" . $uid));

        // DTSTAMP is a required item in VEVENT
        $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZDateHelper::toiCalDateTime((new \DateTime("now", $e["timezone"]))->getTimestamp())));

        // Add description as text
        $eventobj->addNode(new ZCiCalDataNode("DESCRIPTION:" . $e['text description']));

        // Add description as HTML
        $eventobj->addNode(new ZCiCalDataNode("X-ALT-DESC;FMTTYPE=text/html:" . $e['description']));

        // Add location
        $eventobj->addNode(new ZCiCalDataNode("LOCATION:" . ZCiCal::formatContent($e['location'])));

        // Add organizer's email
        $eventobj->addNode(new ZCiCalDataNode("ORGANIZER;CN=organizer:MAILTO:" . ZCiCal::formatContent($e['organizer_email'])));

        // TODO: this is missing a description for the VALARM node. ZCiCal doesn't allow for sub nodes so adding a description just adds it to the main tree
        $eventobj->addNode(new ZCiCalDataNode("BEGIN:VALARM"));
        $eventobj->addNode(new ZCiCalDataNode("TRIGGER:-PT15M"));
        $eventobj->addNode(new ZCiCalDataNode("ACTION:DISPLAY"));
        $eventobj->addNode(new ZCiCalDataNode("END:VALARM"));
        $eventobj->addNode(new ZCiCalDataNode("TRANSP:OPAQUE"));
      }

      return $icalobj->export();

    } else {
      return null;
    }
  }
}
