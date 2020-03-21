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
 * Get start time
 */
define('START_TIME', microtime(true));

/**
 * Define pathes
 */
define('BASE_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

define('SRC', 'src');
define('SRC_PATH', BASE_PATH.SRC.DIRECTORY_SEPARATOR);

define('LOG', 'log');
define('LOG_PATH', BASE_PATH.LOG.DIRECTORY_SEPARATOR);
    
define('APPLICATION', 'Application');
define('APPLICATION_PATH', BASE_PATH.APPLICATION.DIRECTORY_SEPARATOR);
define('APPLICATION_NAMESPACE', APPLICATION.DIRECTORY_SEPARATOR);

define('DATABASE', 'Database');
define('APP_DATABASE_PATH', APPLICATION_PATH.DATABASE.DIRECTORY_SEPARATOR);
define('APP_DATABASE_NAMESPACE', APPLICATION_NAMESPACE.DATABASE.DIRECTORY_SEPARATOR);

define('CONTROLLER', 'Controller');
define('APP_CONTROLLER_NAMESPACE', APPLICATION_NAMESPACE.CONTROLLER.DIRECTORY_SEPARATOR);

define('CONFIG', 'config');
define('CONFIG_PATH', BASE_PATH.CONFIG.DIRECTORY_SEPARATOR);
define('APP_CONFIG_PATH', APPLICATION_PATH.CONFIG.DIRECTORY_SEPARATOR);

define('MAPPING', 'mapping');
define('APP_MAPPING_PATH', APPLICATION_PATH.MAPPING.DIRECTORY_SEPARATOR);

define('VIEW', 'view');
define('APP_VIEW_PATH', APPLICATION_PATH.VIEW.DIRECTORY_SEPARATOR);

/**
 * Register the Autoloader
 */
require_once SRC_PATH.'Core'.DIRECTORY_SEPARATOR.'Autoloader.php';
Autoloader::register(); 

/**
 * Start session
 */
session_start();

/**
 * Initialize the Configuration
 */	 
$Config = Config::getInstance();
$Config->initialize();

/**
 * Migrate the Database
 */
if (Config::get('database/migrateOnAppStart')) {	
	Database::migrate(); 
}