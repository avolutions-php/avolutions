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

namespace Avolutions\Test\TestCases\Routing;

use PHPUnit\Framework\TestCase;

use Avolutions\Routing\Route;

class RouteTest extends TestCase
{
    public function testRouteObjectCanBeCreated()
    {
        $Route = new Route('');

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
    }

    public function testUrlCanBeSet()
    {
        $url = '/route/to/success';
        $Route = new Route($url);

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals($Route->url, $url);
    }

    public function testDefaultsCanBeSet()
    {
        $defaults = [
            'controller' => 'Controller',
            'action' => 'Action',
            'method' => 'Method'
        ];
        $Route = new Route('', $defaults);

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertEquals($Route->controllerName, $defaults['controller']);
        $this->assertEquals($Route->actionName, $defaults['action']);
        $this->assertEquals($Route->method, $defaults['method']);
    }

    public function testParametersCanBeSet()
    {
        $parameters = [
            'parameter1' => [
                'format' => 'format1',
                'optional' => true,
                'default' => 'default1'
            ],
            'parameter2' => [
                'optional' => false
            ],
            'parameter3' => [

            ]
        ];
        $Route = new Route('<parameter1>/<parameter2>/<parameter4>', [], $parameters);

        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);
        $this->assertIsArray($Route->parameters);

        $this->assertArrayHasKey('parameter1', $Route->parameters);
        $this->assertIsArray($Route->parameters['parameter1']);
        $this->assertArrayHasKey('format', $Route->parameters['parameter1']);
        $this->assertArrayHasKey('optional', $Route->parameters['parameter1']);
        $this->assertArrayHasKey('default', $Route->parameters['parameter1']);
        $this->assertEquals('format1', $Route->parameters['parameter1']['format']);
        $this->assertEquals(true, $Route->parameters['parameter1']['optional']);
        $this->assertEquals('default1', $Route->parameters['parameter1']['default']);

        $this->assertArrayHasKey('parameter2', $Route->parameters);
        $this->assertIsArray($Route->parameters['parameter2']);
        $this->assertArrayHasKey('optional', $Route->parameters['parameter2']);
        $this->assertEquals(false, $Route->parameters['parameter2']['optional']);

        $this->assertArrayNotHasKey('parameter3', $Route->parameters);

        $this->assertArrayHasKey('parameter4', $Route->parameters);
        $this->assertIsArray($Route->parameters['parameter4']);
        $this->assertEmpty($Route->parameters['parameter4']);
    }
}