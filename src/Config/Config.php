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

namespace Avolutions\Config;

use Avolutions\Core\Application;

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
        $coreConfigFiles = array_map('basename', glob($this->getConfigPath().'*.php'));
		$appConfigFiles = array_map('basename', glob(Application::getConfigPath().'*.php'));

		$configFiles = array_unique(array_merge($coreConfigFiles, $appConfigFiles));

		foreach ($configFiles as $configFile) {
			$coreConfigValues = self::loadConfigFile($this->getConfigPath().$configFile);
			$appConfigValues = self::loadConfigFile(Application::getConfigPath().$configFile);

			$configValues = array_merge($coreConfigValues, $appConfigValues);

			self::$values[pathinfo($configFile, PATHINFO_FILENAME)] = $configValues;
		}
	}

    /**
     * set
     *
     * Set the value for the given config key. The key is separated by slashes (/).
     *
     * @param string $key The config key (slash separated).
     * @param mixed $value The value to set.
     */
	public static function set(string $key, mixed $value) {
        $identifiers = explode('/', $key);
        $values = &self::$values;

        foreach ($identifiers as $identifier) {
            if (!array_key_exists($identifier, $values)) {
                $values[$identifier] = [];
            }
            $values = &$values[$identifier];
        }

        $values = $value;
        unset($values);
    }

    /**
     * getConfigPath
     *
     * Returns the path to the core config files.
     *
     * @return string The core config path.
     */
    private function getConfigPath(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
    }
}