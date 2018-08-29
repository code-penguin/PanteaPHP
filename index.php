<?php

use Services\Router;

// Enable error reporting for debugging purposes.
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Autoload classes based on a 1:1 mapping from namespace to directory structure.
spl_autoload_register(function ($classPath) {

  // Make sure the class path has the correct directory separator.
  $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $classPath);

  $file = __DIR__ . DIRECTORY_SEPARATOR . $classPath . ".php";

  if (is_readable($file)) {
    require_once $file;
  }
});

// Initialize the router and parse the URI. When an error occurs, show it to the visitor.
$router = new Router();
try {
  $router->parse($_SERVER['REQUEST_URI']);
}
catch (\Exception $error) {
  var_dump($error->getMessage());
}
