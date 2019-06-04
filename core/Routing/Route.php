<?php
/**
 * AVOLUTIONS
 * 
 * An open source PHP framework.
 * 
 * @package		AVOLUTIONS
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		http://framework.avolutions.de
 * @since		Version 1.0.0 * 
 */

namespace core\Routing;

/**
 * Route class
 *
 * A Route object which will be added to the RouteCollection.
 * The Router class will find the corresponding Route object for 
 * the current request.  
 *
 * @package		AVOLUTIONS
 * @subpackage	Core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/route
 * @since		Version 1.0.0 *
 */
class Route 
{
	/**
	 * The url of the Route
	 * 
	 * @var string 
	 */
	public $url;
	
	/**
	 * An array of default values for the Route
	 * 
	 * @var array
	 */
	public $defaults = array();
	
	
	/**
	 * Constructor for a Route
	 * 
	 * Creates a new Route object with the given parameters.
	 * 	 * 
	 * @param string $url The URL that will be mapped
	 * @param array $defaults Default values for the Route
	 * 		$defaults = [
	 * 			'controller'	=> string Name of the controller
	 * 			'action'		=> string Name of the action
	 * 			'method'		=> string Name of the method (GET|POST)
	 * 			'{param}' = [	=> string Name of the parameter
	 * 				'format'	=> string RegEx for valid format
	 * 				'default'	=> string Default value for the parameter
	 * 			]
	 * 		]		 						  
	 *
	 */
	public function __construct($url, $defaults = null) {
		$this->url = $url;
		$this->defaults = $defaults;
	}
}
?>