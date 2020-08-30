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

class RouteCollectionTest extends TestCase
{
    public function testRouteCollectionCanBeCreated()
    {
        $RouteCollection = RouteCollection::getInstance();
        
        $this->assertInstanceOf('Avolutions\Routing\RouteCollection', $RouteCollection);    
    }

    public function testRoutesCanBeAddedToCollection()
    {
        $RouteCollection = RouteCollection::getInstance();
        $Route = new Route('');
        $Route2 = new Route('', ['method' => 'POST']);
        
        $RouteCollection->addRoute($Route);
        $RouteCollection->addRoute($Route2);

        $this->assertContains($Route, $RouteCollection->items);        
        $this->assertContains($Route2, $RouteCollection->items);
    }

    public function testCountItemsOfCollection()
    {
        $RouteCollection = RouteCollection::getInstance();

        $this->assertEquals(2, $RouteCollection->count());
    }

    public function testGetAllItemsOfCollection()
    {
        $RouteCollection = RouteCollection::getInstance();

        $allItems = $RouteCollection->getAll();

        $this->assertEquals(2, count($allItems));
        $this->assertInstanceOf('Avolutions\Routing\Route', $allItems[0]);
        $this->assertInstanceOf('Avolutions\Routing\Route', $allItems[1]);
    }

    public function testGetAllItemsByMethodOfCollection()
    {
        $RouteCollection = RouteCollection::getInstance();

        $allGet = $RouteCollection->getAllByMethod('GET');        
        $allPost = $RouteCollection->getAllByMethod('POST');

        $this->assertEquals(1, count($allGet));        
        $this->assertEquals(1, count($allPost));
        $this->assertInstanceOf('Avolutions\Routing\Route', $allGet[0]);
        $this->assertInstanceOf('Avolutions\Routing\Route', $allPost[0]);
        $this->assertEquals($allGet[0]->method, 'GET');        
        $this->assertEquals($allPost[0]->method, 'POST');
    }
}