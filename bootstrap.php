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

use Avolutions\Core\Autoloader;
use Avolutions\Config\Config;
use Avolutions\Database\Database;

/**
 * Get start time
 */
define('START_TIME', microtime(true));

/**
 * Define folders
 */
define('APPLICATION', 'application');
define('CONFIG', 'config');
define('LOG', 'log');
define('SRC', 'src');

define('CONTROLLER', 'Controller');
define('DATABASE', 'Database');
define('LISTENER', 'Listener');
define('MAPPING', 'Mapping');
define('MODEL', 'Model');
define('VALIDATION', 'Validation');
define('VALIDATOR', 'Validator');
define('VIEW', 'View');
define('VIEWMODEL', 'Viewmodel');

/**
 * Define pathes
 */
define('BASE_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

define('APPLICATION_PATH', BASE_PATH.APPLICATION.DIRECTORY_SEPARATOR);
define('CONFIG_PATH', BASE_PATH.CONFIG.DIRECTORY_SEPARATOR);
define('LOG_PATH', BASE_PATH.LOG.DIRECTORY_SEPARATOR);    
define('SRC_PATH', BASE_PATH.SRC.DIRECTORY_SEPARATOR);
define('VALIDATION_PATH', BASE_PATH.SRC.DIRECTORY_SEPARATOR.VALIDATION.DIRECTORY_SEPARATOR);

define('APP_CONFIG_PATH', APPLICATION_PATH.ucfirst(CONFIG).DIRECTORY_SEPARATOR);
define('APP_DATABASE_PATH', APPLICATION_PATH.DATABASE.DIRECTORY_SEPARATOR);
define('APP_MAPPING_PATH', APPLICATION_PATH.MAPPING.DIRECTORY_SEPARATOR);
define('APP_VIEW_PATH', APPLICATION_PATH.VIEW.DIRECTORY_SEPARATOR);

/**
 * Define namespace
 */
define('AVOLUTIONS_NAMESPACE', 'Avolutions'.'\\');
define('VALIDATOR_NAMESPACE', AVOLUTIONS_NAMESPACE.VALIDATION.'\\');

/**
 * Register the Autoloader
 */
require_once SRC_PATH.'Core'.DIRECTORY_SEPARATOR.'Autoloader.php';
Autoloader::register(); 

/**
 * Set error handler
 */
$ErrorHandler = new Avolutions\Core\ErrorHandler();
set_error_handler([$ErrorHandler, 'handleError']);
set_exception_handler([$ErrorHandler, 'handleException']);

/**
 * Initialize the Configuration
 */	 
$Config = Config::getInstance();
$Config->initialize();

/**
 * Define application namespaces
 */
define('APPLICATION_NAMESPACE', Config::get('application/namespace'));
define('APP_CONTROLLER_NAMESPACE', APPLICATION_NAMESPACE.'\\'.CONTROLLER.'\\');
define('APP_DATABASE_NAMESPACE', APPLICATION_NAMESPACE.'\\'.DATABASE.'\\');
define('APP_LISTENER_NAMESPACE', APPLICATION_NAMESPACE.'\\'.LISTENER.'\\');
define('APP_MODEL_NAMESPACE', APPLICATION_NAMESPACE.'\\'.MODEL.'\\');

/**
 * Migrate the Database
 */
if (Config::get('database/migrateOnAppStart')) {	
	Database::migrate(); 
}
