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

print 'test';
/**
 * Define paths
 */
define(__NAMESPACE__.'\\BASE_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\CONFIG_PATH', BASE_PATH.'config'.DIRECTORY_SEPARATOR);

define(__NAMESPACE__.'\\APPLICATION_PATH', BASE_PATH.'application'.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_CONFIG_PATH', APPLICATION_PATH.'Config'.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_DATABASE_PATH', APPLICATION_PATH.'Database'.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_MAPPING_PATH', APPLICATION_PATH.'Mapping'.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_VIEW_PATH', APPLICATION_PATH.'View'.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_TRANSLATION_PATH', APPLICATION_PATH.'Translation'.DIRECTORY_SEPARATOR);

/**
 * Define namespace
 */
define(__NAMESPACE__.'\\VALIDATOR_NAMESPACE', 'Avolutions\\Validation\\');
define(__NAMESPACE__.'\\APP_CONTROLLER_NAMESPACE', 'Application\\Controller\\');
define(__NAMESPACE__.'\\APP_DATABASE_NAMESPACE', 'Application\\Database\\');
define(__NAMESPACE__.'\\APP_LISTENER_NAMESPACE', 'Application\\Listener\\');
define(__NAMESPACE__.'\\APP_MODEL_NAMESPACE', 'Application\\Model\\');
define(__NAMESPACE__.'\\APP_VALIDATOR_NAMESPACE', 'Application\\Validation\\');


get_defined_constants();