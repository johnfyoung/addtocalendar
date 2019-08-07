<?php

function require_all($dir, $depth = 0) {
  // require all php files
  $scan = glob("$dir/*");
  foreach ($scan as $path) {
    if (preg_match('/\.php$/', $path)) {
      require_once $path;
    }
    elseif (is_dir($path)) {
      require_all($path, $depth + 1);
    }
  }
}

function get_controller($cmd) {
  $class_name = "MWAETC\Controllers\\". ucfirst(strtolower($cmd));

  if(class_exists($class_name)) {
    return new $class_name();
  }

  return new MWAETC\Controllers\Notfound();
}
