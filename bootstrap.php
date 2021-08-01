<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace Avolutions;

/**
 * Define folders
 */
define(__NAMESPACE__.'\\CONFIG', 'config');

define(__NAMESPACE__.'\\CONTROLLER', 'Controller');

/**
 * Define paths
 */
define(__NAMESPACE__.'\\BASE_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define(__NAMESPACE__.'\\CONFIG_PATH', BASE_PATH.CONFIG.DIRECTORY_SEPARATOR);


/**
 * Define namespace
 */
define(__NAMESPACE__.'\\AVOLUTIONS_NAMESPACE', 'Avolutions'.'\\');

define(__NAMESPACE__.'\\COMMAND_NAMESPACE', AVOLUTIONS_NAMESPACE.COMMAND.'\\');
define(__NAMESPACE__.'\\VALIDATOR_NAMESPACE', AVOLUTIONS_NAMESPACE.VALIDATION.'\\');
