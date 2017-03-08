<?php

namespace FlexRouter;

use FlexRouter\FlexRoute;
use FlexRouter\Utilities\FlexParser;

/**
 * Class FlexRouter
 *
 * FlexRouter is a small, lightweight php-router for clean, restful urls. Extremely easy to setup and configure.
 * Supports setting up routes based on their mode (GET, POST).
 * E.x: GET /user/:id/profile or POST /user/:id:/update-profile
 * Supports wildcards as well. E.g. /picture/:id/edit*
 *
 * @author Erlend Ellingsen <erlend.ame@gmail.com>, Robert Cox <robert@studiorclv.com>
 * @version 1.1.0 03.08.2017
 * @package FlexRouter
 */
class FlexRouter {
    /**
     * @var string
     */
    public $basePath = '';

    /**
     * @var bool
     */
    public $routed = false;

    /**
     * @var bool
     */
    public $caseSensitive;

    /**
     * @var bool
     */
    private $cache;

    /**
     * @var array
     */
    private $routes;

    /**
     * @var int
     */
    private $pathCt = 0;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var array
     */
    private $params;

    /**
     * @var
     */
    private $dynParams;

    /**
     * FlexRouter constructor.
     *
     * @param bool $caseSensitive
     * @param bool $cache
     */
    public function __construct($caseSensitive = true, $cache = false)
    {
        $this->caseSensitive = $caseSensitive;
        $this->cache         = $cache;
        $this->routes        = [];

        // Determine the path
        if (!isset($_GET['path'])) {
            $_GET['path'] = '';
        }

        $this->params = explode('/', $_GET['path']);

        if (!$this->caseSensitive) {
            for ($i = 0; $i < count($this->params); $i++) { $this->params[$i] = strtolower($this->params[$i]); }
        }

        $this->pathCt = count($this->params);

        for ($i = 0; $i < $this->pathCt - 1; $i++) {
            $this->basePath .= '../';
        }

        // Determine the mode
        $this->mode = (empty($_POST) ? 'GET' : 'POST');
    }

    /**
     * Registers the routes with the router
     *
     * @param $method
     * @param $route
     * @param $name
     */
    public function registerRoute($method, $route, $name)
    {
        array_push($this->routes, new FlexRoute($method, $route, $name));
    }

    /**
     * Matches the routing
     *
     * Mode: GET/POST
     * Pattern: /users/:id/update
     *
     * @param string $name
     * @return bool
     */
    public function route($name)
    {
        $route           = $this->getRoute($name);
        $mode            = $route->getMethod();
        $pattern         = $route->getRoute();
        $parser          = new FlexParser($this->mode, $this->caseSensitive, $this->params, $this->pathCt);

        return $parser->parse($mode, $pattern);
    }

    /**
     * Returns the matched route
     *
     * @param $name
     * @return FlexRoute
     */
    private function getRoute($name)
    {
        $match = array_filter($this->routes, function ($route) use ($name) {
            if ($route->getName() === $name) {
                return $route;
            }

            return null;
        });

        return array_values($match)[0];
    }
}
