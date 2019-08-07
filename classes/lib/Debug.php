<?php

namespace MWAETC\Lib;

/**
 * Class Debug
 *
 * A utility for printing variables while debugging
 * @package MWAETC\Lib
 */
class Debug {
  public static function log($label, $value) {
    printf("<div>%s<pre>%s</pre></div>", $label, print_r($value, true));
  }
}
