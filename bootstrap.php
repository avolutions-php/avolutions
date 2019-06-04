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
 * @since		Version 1.0.0
 * 
 */
 
use core\Autoloader;

/**
 * Define pathes
 */
define("BASEPATH", realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
	
define("APPLICATIONPATH", BASEPATH."application".DIRECTORY_SEPARATOR);
define("COREPATH", BASEPATH."core".DIRECTORY_SEPARATOR);

/**
 * Register the Autoloader
 */
require_once COREPATH.'Autoloader.php';
Autoloader::register(); 
?>