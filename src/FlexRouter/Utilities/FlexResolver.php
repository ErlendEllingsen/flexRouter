<?php

namespace FlexRouter\Utilities;

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
     * @var FlexRouter
     */
    private $router;

    /**
     * @var FlexParser
     */
    private $parser;

    /**
     * FlexResolver constructor.
     *
     * @param $requestMethod
     * @param $requestUri
     * @param FlexRouter $flexRouter
     * @param FlexParser $flexParser
     */
    public function __construct(
        $requestMethod,
        $requestUri,
        FlexRouter $flexRouter,
        FlexParser $flexParser = null
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
        $route = $this->router->route($name);

        if ($this->parser->parse($route)) {
            return true;
        }

        return false;
    }
}