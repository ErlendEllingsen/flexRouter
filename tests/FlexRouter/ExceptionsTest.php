<?php

namespace FlexRouter\Tests;

use FlexRouter\Exceptions\ParameterNotFoundException;
use FlexRouter\Exceptions\RouteNotFoundException;
use FlexRouter\FlexRouter;
use FlexRouter\Utilities\FlexResolver;
use PHPUnit\Framework\TestCase;

class ExceptionsTest extends TestCase
{
    /**
     * Tests the route not found exception
     */
    public function testRouteNotFoundException()
    {
        $this->expectException(RouteNotFoundException::class);
        $router = new FlexRouter();
        $router->registerRoute('GET', '/', 'homepage');

        $resolver = new FlexResolver('GET', '/asdf', $router);
        $resolver->notFound();
    }

    /**
     * Tests the parameter not found exception
     */
    public function testParameterNotFoundException()
    {
        $this->expectException(ParameterNotFoundException::class);
        $router = new FlexRouter();
        $router->registerRoute('GET', '/', 'homepage');

        $resolver = new FlexResolver('GET', '/', $router);

        if ($resolver->resolve('homepage')) {
            $resolver->access()->params('url', 'id');
        }

        $resolver->notFound();
    }
}