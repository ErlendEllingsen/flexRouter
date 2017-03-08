<?php

namespace FlexRouter;

class FlexRoute
{
    /**
     * @var string|array
     */
    private $method;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $name;

    /**
     * FlexRoute constructor.
     *
     * @param $method
     * @param $route
     * @param $name
     */
    public function __construct($method, $route, $name)
    {
        $this->method = $method;
        $this->route  = $route;
        $this->name   = $name;
    }

    /**
     * Returns the name of the route
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns the name of the route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Returns the name of the route
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}