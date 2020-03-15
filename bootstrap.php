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
 
use Avolutions\Core\Autoloader;
use Avolutions\Config\Config;
use Avolutions\Database\Database;

/**
 * Define pathes
 */
define("BASEPATH", realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
	
define("APPLICATION_PATH", BASEPATH."application".DIRECTORY_SEPARATOR);
define("SRC_PATH", BASEPATH."src".DIRECTORY_SEPARATOR);
define("CONFIG_PATH", BASEPATH."config".DIRECTORY_SEPARATOR);
define("LOG_PATH", BASEPATH."log".DIRECTORY_SEPARATOR);

define("APP_CONFIG_PATH", APPLICATION_PATH."config".DIRECTORY_SEPARATOR);
define("APP_CONTROLLER_PATH", APPLICATION_PATH."controller".DIRECTORY_SEPARATOR);
define("APP_DATABASE_PATH", APPLICATION_PATH."database".DIRECTORY_SEPARATOR);
define("APP_MODEL_PATH", APPLICATION_PATH."model".DIRECTORY_SEPARATOR);
define("APP_MAPPING_PATH", APPLICATION_PATH."mapping".DIRECTORY_SEPARATOR);
define("APP_VIEW_PATH", APPLICATION_PATH."view".DIRECTORY_SEPARATOR);
define("APP_VIEWMODEL_PATH", APPLICATION_PATH."viewmodel".DIRECTORY_SEPARATOR);

/**
 * Register the Autoloader
 */
require_once SRC_PATH.'Core'.DIRECTORY_SEPARATOR.'Autoloader.php';
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