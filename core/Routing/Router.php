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
 * TODO
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
	 * TODO
	 * 
	 * @param string $path
	 */
	public static function findRoute($path) {
		$RouteCollection = RouteCollection::getInstance();
		
		foreach ($RouteCollection->getRoutes() as $Route) {
			if (preg_match($Route->regEx, $path, $matches)) {
				print_r($Route);
			}
		}				
	}
}
?>