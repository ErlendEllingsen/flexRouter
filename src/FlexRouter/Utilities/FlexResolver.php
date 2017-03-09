<?php

namespace FlexRouter\Utilities;

use FlexRouter\Contracts\FlexParserInterface;
use FlexRouter\Exceptions\RouteNotFoundException;
use FlexRouter\FlexRoute;
use FlexRouter\FlexRouter;

/**
 * Class FlexResolver
 *
 * @package FlexRouter\Utilities
 */
class FlexResolver
{
    /**
     * @var string
     */
    private $requestMethod;

    /**
     * @var string
     */
    private $requestUri;

    /**
     * @var FlexParser
     */
    private $parser;

    /**
     * @var FlexRouter
     */
    private $router;

    /**
     * @var FlexRoute
     */
    private $route;

    /**
     * @var string
     */
    private $routeName;

    /**
     * FlexResolver constructor.
     *
     * @param $requestMethod
     * @param $requestUri
     * @param FlexRouter $flexRouter
     * @param FlexParserInterface $flexParser
     */
    public function __construct(
        $requestMethod,
        $requestUri,
        FlexRouter $flexRouter,
        FlexParserInterface $flexParser = null
    ) {
        $this->requestMethod = $requestMethod;
        $this->requestUri    = $requestUri;
        $this->router        = $flexRouter;
        $this->parser        = $flexParser;

        if ($flexParser === null) {
            $this->parser = new FlexParser($requestMethod, $requestUri);
        }
    }

    /**
     * Resolves the route through the parser and returns a bool
     * value depending on whether or not it was successfully resolved
     *
     * @param $name
     * @return bool
     */
    public function resolve($name)
    {
        $this->routeName = $name;
        $route           = $this->router->route($name);

        if ($this->parser->parse($route)) {
            $routeObject = $this->router->getRoute($name);
            $routeObject->setParams($this->parser->getParameters());

            return true;
        }

        return false;
    }

    /**
     * Selects the route to access
     *
     * @return $this
     */
    public function access()
    {
        $this->route = $this->router->getRoute($this->routeName);

        return $this;
    }

    /**
     * Returns the param from the route
     *
     * @param $pool
     * @param $property
     * @return mixed
     */
    public function params($pool, $property)
    {
        return $this->route->getParam($pool, $property);
    }

    /**
     * This is the not found catch all function
     *
     * @param callable|null $handle
     * @throws RouteNotFoundException
     */
    public function notFound(Callable $handle = null)
    {
        if ($handle === null) {
            throw new RouteNotFoundException(null);
        }

        $handle();
    }
}