<?php

namespace FlexRouter\Utilities;

use stdClass;

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
     * @var
     */
    private $routeParams;

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

        if ($this->matchSimpleRoute($route['route'])) {
            return true;
        }

        if ($this->matchPlaceholderRoute($route['route'])) {
            return true;
        }

        if ($this->matchWildcardRoute($route['route'])) {
            return true;
        }

        return false;
    }

    /**
     * Returns the route parameters
     *
     * @return mixed
     */
    public function getParameters()
    {
        return $this->routeParams;
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
        $uriParams = explode('?', $this->requestUri);

        if ($route === $uriParams[0]) {
            $this->routeParams = $this->retrieveParams($route);

            return true;
        }

        return false;
    }

    /**
     * Matches A Placeholder Route
     *
     * @param $route
     * @return bool
     */
    private function matchPlaceholderRoute($route)
    {
        $uriParams    = explode('?', $this->requestUri);
        $sections     = explode('/', $route);
        $uriSections  = explode('/', $uriParams[0]);

        if (count($sections) !== count($uriSections)) {
            return false;
        }

        foreach ($sections as $key => $section) {
            if (strpos($section, ':') === false && $section !== $uriSections[$key]) {
                return false;
            }
        }

        if (strpos($route, ':') !== false) {
            $this->routeParams = $this->retrieveParams($route);

            return true;
        }

        return false;
    }

    /**
     * Matches A Wildcard Route
     *
     * @param $route
     * @return bool
     */
    private function matchWildcardRoute($route)
    {
        $uriParams    = explode('?', $this->requestUri);
        $sections     = explode('/', $route);
        $uriSections  = explode('/', $uriParams[0]);

        foreach ($sections as $key => $section) {
            if (str_replace('*', '', $section) !== $uriSections[$key]) {
                return false;
            }
        }

        if (strpos($route, '*') !== false) {
            $this->routeParams = $this->retrieveParams($route);

            return true;
        }

        return false;
    }

    /**
     * Retrieves all parameters for the request
     *
     * Includes all of the route placeholder parameters, all of the GET parameters, and
     * all of the POST parameters.
     *
     * @param $route
     * @return stdClass
     */
    private function retrieveParams($route)
    {
        $params       = new stdClass();
        $uriParams    = explode('?', $this->requestUri);
        $sections     = explode('/', $route);
        $uriSections  = explode('/', $uriParams[0]);
        $params->post = $this->retrievePOSTParams();
        $params->get  = $this->retrieveGETParams($uriParams);
        $params->url  = $this->retrieveUrlParams($sections, $uriSections);

        return $params;
    }

    /**
     * Retrieves and maps the GET parameters
     *
     * @param $uriParams
     * @return null|stdClass
     */
    private function retrieveGETParams($uriParams)
    {
        $getParams = new stdClass();

        if (isset($uriParams[1])) {
            foreach ($_GET as $key => $param) {
                $getParams->$key = $param;
            }

            return $getParams;
        }

        return $getParams = null;
    }

    /**
     * Retrieves and maps the POST parameters
     *
     * @return null|stdClass
     */
    private function retrievePOSTParams()
    {
        $postParams = new stdClass();

        if (isset($uriParams[1])) {
            foreach ($_POST as $key => $param) {
                $postParams->$key = $param;
            }

            return $postParams;
        }

        return $postParams = null;
    }

    /**
     * Retrieves and matches up the URL parameters
     *
     * @param $sections
     * @param $uriSections
     * @return stdClass
     */
    private function retrieveUrlParams($sections, $uriSections)
    {
        $placeholders = new stdClass();

        array_shift($sections);
        array_shift($uriSections);

        foreach ($sections as $key => $section) {
            if (strpos($section, ':') !== false) {
                $name = str_replace(':', '', $section);
                $placeholders->$name = $uriSections[$key];
            }
        }

        return $placeholders;
    }
}