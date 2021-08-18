<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

use PHPUnit\Framework\TestCase;

use Avolutions\Routing\Route;
use Avolutions\Routing\RouteCollection;
use Avolutions\Routing\Router;

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        $RouteCollection = RouteCollection::getInstance();
        $RouteCollection->items = [];

        $RouteCollection->addRoute(new Route('/user/<id>',
        [
            'controller' => 'user',
            'action'	 => 'show'
        ],
        [
            'id' => [
                'format'   => '[0-9]'
            ]
        ]
        ));

        $RouteCollection->addRoute(new Route('/user/delete/<id>',
        [
            'controller' => 'user',
            'action'	 => 'delete'
        ],
        [
            'id' => [
                'format'   => '[0-9]',
                'optional' => true
            ]
        ]
        ));

        $RouteCollection->addRoute(new Route('/user/edit/<id>',
        [
            'controller' => 'user',
            'action'	 => 'edit'
        ],
        [
            'id' => [
                'format'   => '[0-9]',
                'optional' => true,
                'default'  => 1
            ]
        ]
        ));

        $RouteCollection->addRoute(new Route('/<controller>/<action>'));

        $RouteCollection->addRoute(new Route('/<controller>/<action>/<param1>/<param2>'));
    }

    public function testRouteWithDynamicControllerAndAction()
    {
        $Route = Router::findRoute('/user/new', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals('user', $Route->controllerName);
        $this->assertEquals('new', $Route->actionName);
        $this->assertEquals('GET', $Route->method);
    }

    public function testRouteWithParameter()
    {
        $Route = Router::findRoute('/user/9', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals('user', $Route->controllerName);
        $this->assertEquals('show', $Route->actionName);
        $this->assertEquals('GET', $Route->method);
        $this->assertEquals(9, $Route->parameters[0]);
    }

    public function testRouteWithOptionalParameter()
    {
        $Route = Router::findRoute('/user/delete', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals('user', $Route->controllerName);
        $this->assertEquals('delete', $Route->actionName);
        $this->assertEquals('GET', $Route->method);
        $this->assertEmpty($Route->parameters);
    }

    public function testRouteWithParameterDefaultValue()
    {
        $Route = Router::findRoute('/user/edit', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals('user', $Route->controllerName);
        $this->assertEquals('edit', $Route->actionName);
        $this->assertEquals('GET', $Route->method);
        $this->assertEquals(1, $Route->parameters[0]);
    }

    public function testRouteWithMultipleParameters()
    {
        $Route = Router::findRoute('/user/copy/4711/Foo-Bar_0815', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals('user', $Route->controllerName);
        $this->assertEquals('copy', $Route->actionName);
        $this->assertEquals('GET', $Route->method);
        $this->assertEquals('4711', $Route->parameters[0]);
        $this->assertEquals('Foo-Bar_0815', $Route->parameters[1]);
    }
}