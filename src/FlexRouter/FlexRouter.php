<?php

namespace FlexRouter;

use FlexRouter\Exceptions\RouteNotFoundException;
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
    private $cache;

    /**
     * @var array
     */
    private $routes;

    /**
     * FlexRouter constructor.
     *
     * @param bool $cache
     */
    public function __construct($cache = false)
    {
        $this->cache  = $cache;
        $this->routes = [];
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
     * @return array
     */
    public function route($name)
    {
        $routeObject  = $this->getRoute($name);
        $method       = $routeObject->getMethod();
        $route        = $routeObject->getRoute();

        return [
            'method' => $method,
            'route'  => $route,
        ];
    }

    /**
     * Returns the matched route
     *
     * @param $name
     * @return FlexRoute
     * @throws RouteNotFoundException
     */
    private function getRoute($name)
    {
        $match = null;

        foreach ($this->routes as $route) {
            if ($route->getName() === $name) {
                $match = $route;
            }
        }

        if ($match === null) {
            throw new RouteNotFoundException(null);
        }

        return $match;
    }
}
