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

use core\Routing\Router;

/**
 * Load the bootstrap file * 
 */
require_once "../bootstrap.php";


/**
 * Load the routes file
 */
require_once "../routes.php"; 


/**
 * TODO
 */
print_r(Router::findRoute(parse_url($_SERVER['REQUEST_URI'])['path']));
?>