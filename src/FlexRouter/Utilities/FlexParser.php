<?php

namespace FlexRouter\Utilities;

/**
 * Class FlexParser
 *
 * @package FlexRouter\Utilities
 */
class FlexParser
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
        if (!$this->validMethod($route['methods'])) {
            return false;
        }

        $simple = $this->matchSimpleRoute($route['route']);

        if ($simple) {
            return true;
        }

        return false;
    }

    /**
     * Validates the method used is applicable to the selected route
     *
     * @param $methods
     * @return bool
     */
    private function validMethod($methods)
    {
        if (is_array($methods)) {
            foreach ($methods as $method) {
                if ($method === $this->requestMethod) {
                    return true;
                }
            }
        }

        if ($methods === $this->requestMethod) {
            return true;
        }

        return false;
    }

    /**
     * Matches a simple route based upon the URI
     *
     * @param $route
     * @return bool
     */
    private function matchSimpleRoute($route)
    {
        if ($route === $this->requestUri) {
            return true;
        }

        return false;
    }
}