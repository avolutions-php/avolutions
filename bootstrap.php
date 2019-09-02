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
 * @since		Version 1.0.0
 * 
 */
 
use core\Autoloader;

/**
 * Define pathes
 */
define("BASEPATH", realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
	
define("APPLICATION_PATH", BASEPATH."application".DIRECTORY_SEPARATOR);
define("CORE_PATH", BASEPATH."core".DIRECTORY_SEPARATOR);

define("CORE_CLASS_PATH", CORE_PATH."class".DIRECTORY_SEPARATOR);
define("APP_CONFIG_PATH", APPLICATION_PATH."config".DIRECTORY_SEPARATOR);
define("APP_CONTROLLER_PATH", APPLICATION_PATH."controller".DIRECTORY_SEPARATOR);
define("APP_VIEW_PATH", APPLICATION_PATH."view".DIRECTORY_SEPARATOR);

/**
 * Register the Autoloader
 */
require_once CORE_CLASS_PATH.'Autoloader.php';
Autoloader::register(); 
?>