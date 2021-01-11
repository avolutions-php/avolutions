<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright	Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */

namespace Avolutions\Config;

use Avolutions\Config\ConfigFileLoader;

/**
 * Config class
 *
 * The Config class loads all config files at the bootstrapping and can be used to
 * get the config values anywhere in the framework or application.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Config extends ConfigFileLoader
{
	/**
	 * initialize
	 *
	 * Loads all config values from the config files of core and app. The app configs
	 * overrides the config values of the core.
	 */
    public function initialize()
    {
		$coreConfigFiles = array_map('basename', glob(CONFIG_PATH.'*.php'));
		$appConfigFiles = array_map('basename', glob(APP_CONFIG_PATH.'*.php'));

		$configFiles = array_unique(array_merge($coreConfigFiles, $appConfigFiles));

		foreach ($configFiles as $configFile) {
			$configValues = [];
			$coreConfigValues = [];
			$appConfigValues = [];

			$coreConfigValues = self::loadConfigFile(CONFIG_PATH.$configFile);
			$appConfigValues = self::loadConfigFile(APP_CONFIG_PATH.$configFile);

			$configValues = array_merge($coreConfigValues, $appConfigValues);

			self::$values[pathinfo($configFile, PATHINFO_FILENAME)] = $configValues;
		}
	}
}