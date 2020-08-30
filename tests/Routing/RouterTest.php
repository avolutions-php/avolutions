<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2020 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
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

        $RouteCollection->addRoute(new Route('/<controller>/<action>/<param1>/<param2>',
        [],
        [
            'param1' => [
                'format'   => '[0-9]'
            ],
            'param2' => [
                'format'   => '[0-9]'
            ]
        ]
        ));
    }

    public function testRouteWithDynamicControllerAndAction()
    {
        $Route = Router::findRoute('/user/new', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals($Route->controllerName, 'user');
        $this->assertEquals($Route->actionName, 'new'); 
        $this->assertEquals($Route->method, 'GET');
    }

    public function testRouteWithParameter()
    {
        $Route = Router::findRoute('/user/9', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals($Route->controllerName, 'user');
        $this->assertEquals($Route->actionName, 'show');  
        $this->assertEquals($Route->method, 'GET');
        $this->assertEquals($Route->parameters[0], 9);
    }

    public function testRouteWithOptionalParameter()
    {
        $Route = Router::findRoute('/user/delete', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals($Route->controllerName, 'user');
        $this->assertEquals($Route->actionName, 'delete');  
        $this->assertEquals($Route->method, 'GET');
        $this->assertEmpty($Route->parameters);
    }

    public function testRouteWithParameterDefaultValue()
    {
        $Route = Router::findRoute('/user/edit', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals($Route->controllerName, 'user');
        $this->assertEquals($Route->actionName, 'edit');  
        $this->assertEquals($Route->method, 'GET');
        $this->assertEquals($Route->parameters[0], 1);
    }

    public function testRouteWithMultipleParameters()
    {
        $Route = Router::findRoute('/user/copy/1/2', 'GET');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals($Route->controllerName, 'user');
        $this->assertEquals($Route->actionName, 'copy');  
        $this->assertEquals($Route->method, 'GET');
        $this->assertEquals($Route->parameters[0], 1);
        $this->assertEquals($Route->parameters[1], 2);
    }
}