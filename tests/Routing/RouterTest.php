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
    public function testRouteCanBeFound()
    {
        $RouteCollection = RouteCollection::getInstance();
        $RouteCollection->items = [];

        
    }
}