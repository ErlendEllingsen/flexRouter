<?php

namespace FlexRouter;

use FlexRouter\Exceptions\ParameterNotFoundException;

/**
 * Class FlexRoute
 *
 * @package FlexRouter
 */
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
     * @var
     */
    private $params;

    /**
     * FlexRoute constructor.
     *
     * @param $method
     * @param $route
     * @param $name
     */
    public function __construct(
        $method,
        $route,
        $name
    ) {
        $this->method = $method;
        $this->route  = $route;
        $this->name   = $name;
    }

    /**
     * Sets the parameters for the request
     *
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
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

    /**
     * Returns the requested parameter
     *
     * @param $pool
     * @param $property
     * @return mixed
     */
    public function getParam($pool, $property)
    {
        $param = isset($this->params->$pool->$property) ? $this->params->$pool->$property : false;

        if (!$param) {
            throw new ParameterNotFoundException("the parameter $property was not found in the $pool pool");
        }

        return $param;
    }
}