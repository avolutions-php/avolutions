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
 * 
 */

use core\Routing\RouteCollection;
use core\Routing\Route;
use core\Routing\Router;

$RouteCollection = RouteCollection::getInstance();

/**
 * Register routes
 */
 
/* Example 
$RouteCollection->addRoute(new Route('/<controller>/<action>/<id>',
	array(
		'method' => 'POST'
	),
	array(
		'id' => array(
			'format'   => '[0-9]*',
			'optional' => true,
			'default'  => 1
		)
	)	
));
*/ 
?>