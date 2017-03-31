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
     * Tests a simple match
     */
    public function testNonWildCardGET()
    {
        $router = new FlexRouter();
        $router->registerRoute('GET', '/', 'homepage');

        $resolver = new FlexResolver('GET', '/', $router);

        $this->assertEquals($resolver->resolve('homepage'), true);
    }

    /**
     * Tests a simple match with GET parameters
     */
    public function testNonWildCardGETWithGETParams()
    {
        $_GET['test'] = 'test-value';

        $router = new FlexRouter();
        $router->registerRoute('GET', '/', 'homepage');

        $resolver = new FlexResolver('GET', '/?test=test-value', $router);

        $this->assertEquals($resolver->resolve('homepage'), true);
        $this->assertEquals($resolver->access()->params('get', 'test'), 'test-value');
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

    /**
     * Tests a basic parameter route
     */
    public function testParameterRoutes()
    {
        $router = new FlexRouter();
        $router->registerRoute('GET', '/test/:id/post', 'param');

        $resolver = new FlexResolver('GET', '/test/slug/post', $router);

        $this->assertEquals($resolver->resolve('param'), true);
        $this->assertEquals($resolver->access()->params('url', 'id'), 'slug');
    }

    /**
     * Tests a basic parameter route
     */
    public function testParameterRoutesWithGET()
    {
        $_GET['test'] = 'test-value';

        $router = new FlexRouter();
        $router->registerRoute('GET', '/test/:id/post', 'param');

        $resolver = new FlexResolver('GET', '/test/slug/post?test=test-value', $router);

        $this->assertEquals($resolver->resolve('param'), true);
        $this->assertEquals($resolver->access()->params('url', 'id'), 'slug');
        $this->assertEquals($resolver->access()->params('get', 'test'), 'test-value');
    }

    /**
     * Tests a basic parameter route
     */
    public function testNotFound()
    {
        $router = new FlexRouter();
        $router->registerRoute('GET', '/', 'homepage');

        $resolver = new FlexResolver('GET', '/asdf', $router);

        $resolver->notFound(function () {
            $this->assertEquals(true, true);
        });
    }
}