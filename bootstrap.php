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
 * Define folders
 */
define(__NAMESPACE__.'\\APPLICATION', 'application');
define(__NAMESPACE__.'\\CONFIG', 'config');
define(__NAMESPACE__.'\\LOG', 'log');
define(__NAMESPACE__.'\\SRC', 'src');
define(__NAMESPACE__.'\\TRANSLATION', 'translation');

define(__NAMESPACE__.'\\CONTROLLER', 'Controller');
define(__NAMESPACE__.'\\DATABASE', 'Database');
define(__NAMESPACE__.'\\LISTENER', 'Listener');
define(__NAMESPACE__.'\\MAPPING', 'Mapping');
define(__NAMESPACE__.'\\MODEL', 'Model');
define(__NAMESPACE__.'\\VALIDATION', 'Validation');
define(__NAMESPACE__.'\\VALIDATOR', 'Validator');
define(__NAMESPACE__.'\\VIEW', 'View');
define(__NAMESPACE__.'\\VIEWMODEL', 'Viewmodel');

/**
 * Define paths
 */
define(__NAMESPACE__.'\\BASE_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

define(__NAMESPACE__.'\\CONFIG_PATH', BASE_PATH.CONFIG.DIRECTORY_SEPARATOR);

define(__NAMESPACE__.'\\APPLICATION_PATH', BASE_PATH.APPLICATION.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_CONFIG_PATH', APPLICATION_PATH.ucfirst(CONFIG).DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_DATABASE_PATH', APPLICATION_PATH.DATABASE.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_MAPPING_PATH', APPLICATION_PATH.MAPPING.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_TRANSLATION_PATH', APPLICATION_PATH.TRANSLATION.DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\APP_VIEW_PATH', APPLICATION_PATH.VIEW.DIRECTORY_SEPARATOR);

/**
 * Define namespace
 */
define(__NAMESPACE__.'\\AVOLUTIONS_NAMESPACE', 'Avolutions'.'\\');
define(__NAMESPACE__.'\\VALIDATOR_NAMESPACE', AVOLUTIONS_NAMESPACE.VALIDATION.'\\');

define(__NAMESPACE__.'\\APPLICATION_NAMESPACE', 'Application'.'\\');
define(__NAMESPACE__.'\\APP_CONTROLLER_NAMESPACE', APPLICATION_NAMESPACE.CONTROLLER.'\\');
define(__NAMESPACE__.'\\APP_DATABASE_NAMESPACE', APPLICATION_NAMESPACE.DATABASE.'\\');
define(__NAMESPACE__.'\\APP_LISTENER_NAMESPACE', APPLICATION_NAMESPACE.LISTENER.'\\');
define(__NAMESPACE__.'\\APP_MODEL_NAMESPACE', APPLICATION_NAMESPACE.MODEL.'\\');
define(__NAMESPACE__.'\\APP_VALIDATOR_NAMESPACE', APPLICATION_NAMESPACE.VALIDATION.'\\');