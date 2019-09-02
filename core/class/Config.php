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
 * @since		Version 1.0.0
 */
 
namespace core;

/**
 * Config class
 *
 * The Config class loads all config files at the bootstrapping and can be used to
 * get the config values anywhere in the framework/application.
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @since		Version 1.0.0
 */
class Config extends AbstractSingleton
{
	/**
	 * @var array $configValues An array containing all loaded configuration values
	 */
	private static $configValues = array();
	
	/**
	 * initialize
	 *
	 * Loads all config values from the config files of core and app. The app configs
	 * overrides the config values of the core.
	 */
	public function initialize() {		
		$coreConfigFiles = array_map('basename', glob(CORE_CONFIG_PATH.'*.php'));
		$appConfigFiles = array_map('basename', glob(APP_CONFIG_PATH.'*.php'));
	
		$configFiles = array_unique(array_merge($coreConfigFiles, $appConfigFiles));
		
		foreach($configFiles as $configFile) {
			$configValues = array();
			$coreConfigValues = array();
			$appConfigValues = array();
			
			$coreConfigValues = $this->loadConfigFile(CORE_CONFIG_PATH.$configFile);	
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
	 * @param $key string The key (slash separated) of the config value.
	 *
	 * @return mixed The config value
	 */
	public static function get($key) {
		$identifier = explode('/', $key);
		
		$configValues = self::$configValues;
			
		foreach($identifier as $key => $value) {
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
	private function loadConfigFile($configFile) {				
		if(file_exists($configFile)) {	
			return require $configFile;
		}
		
		return array();
	}
}
?>