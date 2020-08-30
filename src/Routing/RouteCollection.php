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

namespace Avolutions\Routing;

use Avolutions\Collection\CollectionInterface;
use Avolutions\Collection\CollectionTrait;
use Avolutions\Core\AbstractSingleton;

/**
 * RouteCollection class
 *
 * The RouteCollection contains all registered routes (Route objects).
 * The Router class will search in the RouteCollection for a matching route
 * for the Request.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class RouteCollection extends AbstractSingleton implements CollectionInterface
{
	use CollectionTrait;
	
	/**
	 * addRoute
	 * 
	 * Adds an given Route object to the RouteCollection.
	 * 
	 * @param Route $Route An Route object to add to the collection
	 */
    public function addRoute($Route)
    {
		$this->items[] = $Route;
	}
	
	/**
	 * getAllByMethod
	 * 
	 * Returns an array with all Routes of the RouteCollection filtered by the method.
	 *
	 * @param string $method Name of the method (GET|POST)
	 * 
	 * @return array An array with all Routes of the RouteCollection filtered by the method
	 */ 
    public function getAllByMethod($method)
    {
		return array_values(array_filter(
			$this->items,
			function ($Route) use ($method) {
				return $Route->method == $method;
			}
		));
	}	
}