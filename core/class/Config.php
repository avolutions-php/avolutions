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
 * TODO
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @since		Version 1.0.0
 */
class Config extends AbstractSingleton
{
	/**
	 * @var array $configValues An array containing all configuration values
	 */
	private static $configValues = array();
	
	/**
	 * TODO
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
	 * TODO
	 *
	 * @param TODO
	 *
	 * @return TODO
	 */
	public static function get($key) {
		// TODO
	}		
	
	/**
	 * loadConfigFile
	 *
	 * Loads the given config file and return the content.
	 *
	 * @param string $configFile Full filename with path of the config file.
	 * 
	 * @return array An array with the loaded config values.
	 */
	private function loadConfigFile($configFile) {				
		if(file_exists($configFile)) {	
			return require $configFile;
		}
		
		return array();
	}
}
?>