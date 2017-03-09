<?php

namespace FlexRouter\Tests;

use FlexRouter\FlexRouter;
use FlexRouter\Utilities\FlexResolver;
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

        $resolver = new FlexResolver('GET', '/', $router);

        $this->assertEquals($resolver->resolve('homepage'), true);
    }

    /**
     * The initial test to build on
     */
    public function testNonWildCardPOST()
    {
        $router = new FlexRouter();
        $router->registerRoute('POST', '/', 'homepage');

        $resolver = new FlexResolver('POST', '/', $router);

        $this->assertEquals($resolver->resolve('homepage'), true);
    }

    /**
     * Tests to make sure that the method needs to match the registered route
     */
    public function testMethodMismatch()
    {
        $router = new FlexRouter();
        $router->registerRoute('GET', '/', 'homepage');

        $resolver = new FlexResolver('POST', '/', $router);

        $this->assertEquals($resolver->resolve('homepage'), false);
    }

    /**
     * Tests to make sure that the method needs to match the registered route
     */
    public function testMethodArrayMatch()
    {
        $router = new FlexRouter();
        $router->registerRoute(['POST', 'GET'], '/', 'homepage');

        $resolver = new FlexResolver('POST', '/', $router);

        $this->assertEquals($resolver->resolve('homepage'), true);

        $resolver = new FlexResolver('GET', '/', $router);

        $this->assertEquals($resolver->resolve('homepage'), true);
    }

    /**
     * Tests to make sure that the method needs to match the registered route
     */
    public function testMethodArrayMismatch()
    {
        $router = new FlexRouter();
        $router->registerRoute(['GET'], '/', 'homepage');

        $resolver = new FlexResolver('POST', '/', $router);

        $this->assertEquals($resolver->resolve('homepage'), false);
    }
}