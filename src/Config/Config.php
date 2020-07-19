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
 
namespace Avolutions\Config;

use Avolutions\Core\AbstractSingleton;

/**
 * Config class
 *
 * The Config class loads all config files at the bootstrapping and can be used to
 * get the config values anywhere in the framework or application.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Config extends AbstractSingleton
{
	/**
	 * @var array $configValues An array containing all loaded configuration values
	 */
	private static $configValues = [];
	
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
			
			$coreConfigValues = $this->loadConfigFile(CONFIG_PATH.$configFile);	
			$appConfigValues = $this->loadConfigFile(APP_CONFIG_PATH.$configFile);
						
			$configValues = array_merge($coreConfigValues, $appConfigValues);
						
			self::$configValues[pathinfo($configFile, PATHINFO_FILENAME)] = $configValues;
		}
	}
	
	/**
	 * get
	 * 
	 * Returns the config value for the given key. The key is seperated by slashes (/).
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
		
		$configValues = self::$configValues;
			
		foreach ($identifier as $value) {
			if (!isset($configValues[$value])) {
				throw new \Exception('Config key "'.$key.'" could not be found');
			}
			
			$configValues = $configValues[$value];
		}
		
		return $configValues;
	}		
	
	/**
	 * loadConfigFile
	 *
	 * Loads the given config file and return the content (array) or an empty array 
	 * if the file can not be found.
	 *
	 * @param string $configFile Complete name including the path of the config file.
	 * 
	 * @return array An array with the loaded config values or an empty array if 
     *				 file can not be found.
	 */
    private function loadConfigFile($configFile)
    {				
		if (file_exists($configFile)) {	
			return require $configFile;
		}
		
		return [];
	}
}