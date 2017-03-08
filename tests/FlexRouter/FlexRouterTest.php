<?php

namespace FlexRouter\Tests;

use FlexRouter\FlexRouter;
use PHPUnit\Framework\TestCase;

/**
 * Class FlexRouterTest
 *
 * @package FlexRouter\Tests
 */
class FlexRouterTest extends TestCase
{
    /**
     * The initial test to build on
     */
    public function testNonWildCardGET()
    {
        $router = new FlexRouter();
        $route = $router->route('GET', '/');

        $this->assertEquals($route, true);
    }

    /**
     * The initial test to build on
     */
    public function testNonWildCardPOST()
    {
        $router = new FlexRouter();
        $route = $router->route('POST', '/');

        $this->assertEquals($route, true);
    }
}