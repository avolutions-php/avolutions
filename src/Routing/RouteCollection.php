<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		https://github.com/avolutions/avolutions
 */

namespace core\routing;

use core\Singleton;
use core\CollectionInterface;
use core\AbstractSingleton;

/**
 * RouteCollection class
 *
 * The RouteCollection contains all registered routes (Route objects).
 * The Router class will search in the RouteCollection for a matching route
 * for the Request.
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class RouteCollection extends AbstractSingleton implements CollectionInterface
{
	/**
	 * @var array $Routes An array containing all Routes of the RouteCollection
	 */
	private $Routes = array();
	
	/**
	 * addRoute
	 * 
	 * Adds an given Route object to the RouteCollection.
	 * 
	 * @param Route $Route An Route object to add to the collection
	 */
	public function addRoute($Route) {
		$this->Routes[] = $Route;
	}
	
	/**
	 * getAll
	 * 
	 * Returns an array with all Routes of the RouteCollection
	 * 
	 * @return array An array with all Routes of the RouteCollection
	 */ 
	public function getAll() {
		return $this->Routes;
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
	public function getAllByMethod($method) {
		return array_filter(
			$this->Routes,
			function ($Route) use ($method) {
				return $Route->method == $method;
			}
		);
	}
	
}
?>