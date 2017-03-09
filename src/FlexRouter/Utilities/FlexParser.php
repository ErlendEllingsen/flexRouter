<?php

namespace FlexRouter\Utilities;

/**
 * Class FlexParser
 *
 * @package FlexRouter\Utilities
 */
class FlexParser
{
    private $requestMethod;

    private $requestUri;

    /**
     * FlexParser constructor.
     *
     * @param $requestMethod
     * @param $requestUri
     */
    public function __construct($requestMethod, $requestUri)
    {
        $this->requestMethod = $requestMethod;
        $this->requestUri    = $requestUri;
    }

    /**
     * Parses the route and returns the appropriate response.
     *
     * @param $route
     * @return bool
     */
    public function parse($route)
    {
        $simple = $this->matchSimpleRoute($route['method'], $route['route']);

        if ($simple) {
            return true;
        }

        return false;
    }

    /**
     * @param $methods
     * @param $route
     * @return bool
     */
    private function matchSimpleRoute($methods, $route)
    {
        if (is_array($methods)) {
            foreach ($methods as $method) {
                if (
                    $method === $this->requestMethod &&
                    $route  === $this->requestUri
                ) {
                    return true;
                }
            }
        }

        if (
            $methods === $this->requestMethod &&
            $route   === $this->requestUri
        ) {
            return true;
        }

        return false;
    }
}