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

namespace Avolutions\Test\Routing;

use PHPUnit\Framework\TestCase;

use Avolutions\Routing\Route;
use Avolutions\Routing\RouteCollection;

class RouteCollectionTest extends TestCase
{
    public function testRouteCollectionCanBeCreated()
    {
        $RouteCollection = new RouteCollection();

        $this->assertInstanceOf('Avolutions\Routing\RouteCollection', $RouteCollection);
    }

    public function testRoutesCanBeAddedToCollection()
    {
        $RouteCollection = new RouteCollection();
        $Route = new Route('');
        $Route2 = new Route('', ['method' => 'POST']);

        $RouteCollection->addRoute($Route);
        $RouteCollection->addRoute($Route2);

        $this->assertContains($Route, $RouteCollection->items);
        $this->assertContains($Route2, $RouteCollection->items);
    }

    public function testCountItemsOfCollection()
    {
        $RouteCollection = $this->getRouteCollection();

        $this->assertEquals(2, $RouteCollection->count());
    }

    public function testGetAllItemsOfCollection()
    {
        $RouteCollection = $this->getRouteCollection();

        $allItems = $RouteCollection->getAll();

        $this->assertCount(2, $allItems);
        $this->assertInstanceOf('Avolutions\Routing\Route', $allItems[0]);
        $this->assertInstanceOf('Avolutions\Routing\Route', $allItems[1]);
    }

    public function testGetAllItemsByMethodOfCollection()
    {
        $RouteCollection = $this->getRouteCollection();

        $allGet = $RouteCollection->getAllByMethod('GET');
        $allPost = $RouteCollection->getAllByMethod('POST');

        $this->assertCount(1, $allGet);
        $this->assertCount(1, $allPost);
        $this->assertInstanceOf('Avolutions\Routing\Route', $allGet[0]);
        $this->assertInstanceOf('Avolutions\Routing\Route', $allPost[0]);
        $this->assertEquals('GET', $allGet[0]->method);
        $this->assertEquals('POST', $allPost[0]->method);
    }

    private function getRouteCollection(): RouteCollection
    {
        $RouteCollection = new RouteCollection();
        $Route = new Route('');
        $Route2 = new Route('', ['method' => 'POST']);

        $RouteCollection->addRoute($Route);
        $RouteCollection->addRoute($Route2);

        return $RouteCollection;
    }
}