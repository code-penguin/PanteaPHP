<?php

namespace Services;

/**
 * Class Router
 * @package Services
 *
 * Handles routing for the application.
 */
class Router {
  private static $routes;

  public static function add ($type, $path, $callable) {
    self::$routes[$type . ':' . $path] = $callable;
  }

  /**
   * Load the routes file.
   */
  public function __construct () {
    require_once 'routes.php';
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

    $method = $_SERVER['REQUEST_METHOD'];

    $matchingRoute = null;
    $params = [];

    foreach (array_keys(self::$routes) as $route) {
      $keyPattern = '/{[A-Za-z0-9]+}/';
      $valuePattern = '([A-Za-z0-9]+)';
      $routeRegEx = str_replace('/', '\/', $route);
      preg_match_all($keyPattern, $routeRegEx, $keyMatches);
      $uriRegEx = preg_replace($keyPattern, $valuePattern, $routeRegEx);

      $routeMatches = preg_match('/^' . $uriRegEx . '$/', $method . ':' . $uri, $valueMatches);
      if ($routeMatches) {
        $matchingRoute = $route;

        foreach ($keyMatches[0] as $index => $match) {
          $key = str_replace(['{','}'], '', $match);
          $value = $valueMatches[$index+1];
          $params[$key] = $value;
        }
        break;
      }
    }

    if (!$matchingRoute) {
      throw new \Exception('Invalid route: ' . $method . ' ' . $uri);
    }

    $this->loadRoute(self::$routes[$matchingRoute], $params);
  }

  /**
   * Load a route by calling the function on the controller.
   *
   * @param string $route
   * @param array $params
   * @return void
   * @throws \Exception
   */
  private function loadRoute (string $route, array $params) {
    list($controllerName, $functionName) = explode('@', $route);

    // Use the IoCContainer to enable constructor dependency injection for the controller and its dependencies.
    $container = new IoCContainer();
    $controller = $container->build("Controllers\\" . $controllerName);

    if (!method_exists($controller, $functionName)) {
      throw new \Exception("$functionName not found");
    }

    $controller->$functionName($params);
  }
}
