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

/**
 * Router class
 * 
 * The Router class find the matching Route for the url of the Request and
 * invokes the corresponding controller and action.
 *
 * @package		avolutions\core\routing
 * @subpackage	Core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/router
 * @since		Version 1.0.0
 */
class Router
{
	/**
	 * findRoute
	 * 
	 * Finds the matching Route from the RouteCollection by the passed url/path.
	 * 
	 * @param string $path TODO
	 */
	public static function findRoute($path) {
		$RouteCollection = RouteCollection::getInstance();
		$MatchedRoute = null;
		
		foreach ($RouteCollection->getAll() as $Route) {
			if (preg_match($Route->regEx, $path, $matches)) {
				$MatchedRoute = $Route;
				
				break;
			}
		}	
		
		return $MatchedRoute;
	}
}
?>