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

use Avolutions\Core\AbstractSingleton;

/**
 * ConfigFileLoader class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class ConfigFileLoader extends AbstractSingleton
{
	/**
	 * @var array $values An array containing all loaded configuration values
	 */
	protected static $values = [];

	/**
	 * get
	 *
	 * Returns the value for the given key. The key is seperated by slashes (/).
	 *
	 * @param string $key The key (slash separated) of the config value.
     *
     * @throws \Exception
	 *
	 * @return mixed The config value
	 */
    public static function get($key)
    {
		$identifier = explode('/', $key);

		$values = self::$values;

		foreach ($identifier as $value) {
			if (!isset($values[$value])) {
				throw new \Exception('Key "'.$key.'" could not be found');
			}

			$values = $values[$value];
		}

		return $values;
    }

	/**
	 * loadConfigFile
	 *
	 * Loads the given config file and return the content (array) or an empty array
	 * if the file can not be found.
	 *
	 * @param string $configFile Complete name including the path and file extension of the config file.
	 *
	 * @return array An array with the loaded config values or an empty array if
     *				 file can not be found.
	 */
    protected function loadConfigFile($configFile)
    {
		if (file_exists($configFile)) {
			return require $configFile;
		}

		return [];
	}
}