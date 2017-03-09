<?php

namespace FlexRouter\Contracts;

/**
 * Interface FlexParserInterface
 *
 * @package FlexRouter\Contracts
 */
interface FlexParserInterface
{
    /**
     * Parses the route and returns the appropriate response.
     *
     * @param $route
     * @return bool
     */
    public function parse($route);

    /**
     * Returns the route parameters
     *
     * @return mixed
     */
    public function getParameters();
}