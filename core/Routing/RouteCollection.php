<?php
/**
 * AVOLUTIONS
 * 
 * An open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		http://framework.avolutions.de
 * @since		Version 1.0.0 
 */

namespace core\Routing;

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
 * @package		avolutions\core\routing
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/routeCollection
 * @since		Version 1.0.0
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
	
}
?>