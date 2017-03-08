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
        $router->registerRoute('GET', '/', 'homepage');
        $route = $router->route('homepage');

        $this->assertEquals($route, true);
    }

    /**
     * The initial test to build on
     */
    public function testNonWildCardPOST()
    {
        $router = new FlexRouter();
        $router->registerRoute('POST', '/', 'homepage');
        $route = $router->route('homepage');

        $this->assertEquals($route, false);
    }
}