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

use core\logging\Logger;
use core\Request;
use core\routing\Router;

/**
 * Load the bootstrap file
 */
require_once "../bootstrap.php";


/**
 * Load the routes file
 */
require_once "../routes.php"; 


/**
 * Start the application
 */
try {
	$Request = new Request();
	$Response = $Request->send();
} catch(Exception $e) {
	Logger::error($e);
}
?>