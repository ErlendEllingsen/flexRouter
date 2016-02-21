<?php

/**
 * flexRouter - a small, lightweight php-router for clean, restful urls. Extremely easy to setup and configure.
 * Supports setting up routes based on their mode (GET, POST). E.x: GET /user/:id/profile or POST /user/:id:/update-profile
 * @author Erlend Ellingsen <erlend.ame@gmail.com>
 * @version 1.0 21.01.2016
 */
class flexRouter {

  public $mode;
  public $params;
  public $dynParams;

  public function __construct() {

    // Determine the path
    if (!isset($_GET['path'])) $_GET['path'] = '';
    $this->params = explode('/', $_GET['path']);

    // Determine the mode
    $this->mode = (empty($_POST) ? 'GET' : 'POST');
  }

  /**
   * Mode: GET/POST
   * Pattern: /users/:id/update
   */
  public function route($mode, $pattern) {
    $this->dynParams = array();

    // Validate mode
    if (strtolower($mode) != strtolower($this->mode)) return false;

    // Validate pattern
    $routePattern = explode('/', $pattern);
    if (empty($routePattern[0])) unset($routePattern[0]);
    $routePattern = array_values($routePattern);


    if (count($routePattern) != count($this->params)) return false;

    for ($i = 0; $i < count($routePattern); $i++) {
        $patternElement = $routePattern[$i];
      if ($patternElement[0] == ':') {
        $this->dynParams[$patternElement] = $this->params[$i];
        continue;
      }

      if ($patternElement != $this->params[$i]) return false;
      // end of routePattern-loop
    }

    return true;

    // end route-function
  }

  public function param($tag) {
    return $this->dynParams[$tag];
  }

  // end flexRouter
}

?>
