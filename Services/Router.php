<?php

namespace Services;

/**
 * Class Router
 * @package Services
 *
 * Handles routing for the application.
 */
class Router {
  private $routes;

  /**
   * Load the routes file.
   */
  public function __construct () {
    $this->routes = require_once 'routes.php';
  }

  /**
   * Parse a URI and load the matching route.
   *
   * @param string $fullUri
   * @throws \Exception
   */
  public function parse (string $fullUri) {
    $uri = urldecode(
      parse_url($fullUri, PHP_URL_PATH)
    );

    if (!isset($this->routes[$uri])) {
      $uri = '/';
    }
    $this->loadRoute($this->routes[$uri]);
  }

  /**
   * Load a route by calling the function on the controller.
   *
   * @param string $route
   * @return void
   * @throws \Exception
   */
  private function loadRoute (string $route) {
    list($controllerName, $functionName) = explode('@', $route);

    // Use the IoCContainer to enable constructor dependency injection for the controller and its dependencies.
    $container = new IoCContainer();
    $controller = $container->build("Controllers\\" . $controllerName);

    if (!method_exists($controller, $functionName)) {
      throw new \Exception("$functionName not found");
    }

    $controller->$functionName();
  }
}