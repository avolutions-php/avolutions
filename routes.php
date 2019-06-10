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

$RouteCollection->addRoute(new Route('/',
	array(
		'controller'=> 'test',
		'action'	=> '123'
	)
));

$RouteCollection->addRoute(new Route('/controller/action'));

print_r(parse_url($_SERVER['REQUEST_URI']));
print_r($_GET['path']);

Router::findRoute(parse_url($_SERVER['REQUEST_URI'])['path']);
?>