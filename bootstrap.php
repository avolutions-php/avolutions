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
 * 
 */
 
use core\Autoloader;
use core\Config;
use core\database\Database;

/**
 * Define pathes
 */
define("BASEPATH", realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
	
define("APPLICATION_PATH", BASEPATH."application".DIRECTORY_SEPARATOR);
define("CORE_PATH", BASEPATH."core".DIRECTORY_SEPARATOR);

define("CORE_CLASS_PATH", CORE_PATH."class".DIRECTORY_SEPARATOR);
define("CORE_CONFIG_PATH", CORE_PATH."config".DIRECTORY_SEPARATOR);
define("CORE_LOG_PATH", CORE_PATH."log".DIRECTORY_SEPARATOR);

define("APP_CONFIG_PATH", APPLICATION_PATH."config".DIRECTORY_SEPARATOR);
define("APP_CONTROLLER_PATH", APPLICATION_PATH."controller".DIRECTORY_SEPARATOR);
define("APP_DATABASE_PATH", APPLICATION_PATH."database".DIRECTORY_SEPARATOR);
define("APP_VIEW_PATH", APPLICATION_PATH."view".DIRECTORY_SEPARATOR);
define("APP_VIEWMODEL_PATH", APPLICATION_PATH."viewmodel".DIRECTORY_SEPARATOR);

/**
 * Register the Autoloader
 */
require_once CORE_CLASS_PATH.'Autoloader.php';
Autoloader::register(); 

/**
 * Initialize the Configuration
 */	 
$Config = Config::getInstance();
$Config->initialize();	

/**
 * Migrate the Database
 */
if(Config::get("database/migrateOnAppStart")) {	
	Database::migrate(); 
}
?>