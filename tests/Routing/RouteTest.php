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

class RouteTest extends TestCase
{
    public function testRouteObjectCanBeCreated()
    {
        $Route = new Route('');
        
        $this->assertInstanceOf('Avolutions\Routing\Route', $Route);    
    }

    public function testUrlCanBeSet()
    {
        $url = '/route/to/succes'; 
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
        ]; 
        $Route = new Route('', null, $parameters);
        
        $this->assertInstanceOf('Avolutions\Routing\Route', $Route); 
        $this->assertIsArray($Route->parameters);
        $this->assertIsArray($Route->parameters['parameter1']);
        $this->assertIsArray($Route->parameters['parameter2']);
        $this->assertArrayHasKey('format', $Route->parameters['parameter1']);
        $this->assertArrayHasKey('optional', $Route->parameters['parameter1']);
        $this->assertArrayHasKey('default', $Route->parameters['parameter1']);
        $this->assertArrayHasKey('optional', $Route->parameters['parameter2']);        
        $this->assertEquals($Route->parameters['parameter1']['format'], 'format1');
        $this->assertEquals($Route->parameters['parameter1']['optional'], true);
        $this->assertEquals($Route->parameters['parameter1']['default'], 'default1');
        $this->assertEquals($Route->parameters['parameter2']['optional'], false);
    }
}