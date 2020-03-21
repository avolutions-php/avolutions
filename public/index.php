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

use Avolutions\Logging\Logger;
use Avolutions\Http\Request;
use Avolutions\Routing\Router;

/**
 * Load the bootstrap file
 */
require_once '../bootstrap.php';


/**
 * Load the routes file
 */
require_once '../routes.php'; 


/**
 * Start the application
 */
try {
	$Request = new Request();
    $Response = $Request->send();

    Logger::debug("Execution time: ".(microtime(true) - START_TIME)." sec");
} catch (Exception $e) {
	Logger::error($e);
}