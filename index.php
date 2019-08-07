<?php
require "../autoload.php";
require "./includes/functions.php";

define("SERVER_URL", $_SERVER['SERVER_NAME']);
define("SERVER_PORT", $_SERVER['SERVER_PORT'] !== 80 ? ":" . $_SERVER['SERVER_PORT'] : '');
define("PROTOCOL", $_SERVER['HTTPS'] ? "https://" : "http://");

define("FULL_URL", (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI']);
define("ROOT_URL", PROTOCOL . SERVER_URL . SERVER_PORT);
define("CONTROLLER_PATH", __FILE__ ."/classes/controllers");

require_all(dirname(__FILE__) . "/classes/lib");
require_all(dirname(__FILE__) . "/classes/core");
require_all(dirname(__FILE__) . "/classes/controllers");

// get the command
preg_match("/addtocalendar\/([^?\/]*)(.{0,})$/", FULL_URL, $matches);
if(!empty($matches[1])) {
  define("CMD", $matches[1]);
} else {
  define("CMD", "main");
}


$controller = get_controller(CMD);

$controller->execute();
