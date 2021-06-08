<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

namespace Avolutions;

/**
 * Define paths
 */
define(__NAMESPACE__.'\BASE_PATH', realpath('./').DIRECTORY_SEPARATOR);
define('CONFIG_PATH', BASE_PATH.'config'.DIRECTORY_SEPARATOR);

define('APPLICATION_PATH', BASE_PATH.'application'.DIRECTORY_SEPARATOR);
define('APP_CONFIG_PATH', APPLICATION_PATH.'Config'.DIRECTORY_SEPARATOR);
define('APP_DATABASE_PATH', APPLICATION_PATH.'Database'.DIRECTORY_SEPARATOR);
define('APP_MAPPING_PATH', APPLICATION_PATH.'Mapping'.DIRECTORY_SEPARATOR);
define('APP_VIEW_PATH', APPLICATION_PATH.'View'.DIRECTORY_SEPARATOR);
define('APP_TRANSLATION_PATH', APPLICATION_PATH.'Translation'.DIRECTORY_SEPARATOR);

/**
 * Define namespace
 */
define('VALIDATOR_NAMESPACE', 'Avolutions\\Validation\\');
define('APP_CONTROLLER_NAMESPACE', 'Application\\Controller\\');
define('APP_DATABASE_NAMESPACE', 'Application\\Database\\');
define('APP_LISTENER_NAMESPACE', 'Application\\Listener\\');
define('APP_MODEL_NAMESPACE', 'Application\\Model\\');
define('APP_VALIDATOR_NAMESPACE', 'Application\\Validation\\');