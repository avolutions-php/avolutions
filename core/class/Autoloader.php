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
 * Autoloader class
 * 
 * Autoloads all required classes
 * 
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @since		Version 1.0.0
 */
class Autoloader 
{	
	/**
	 * Includes all required files
	 * 
	 * This method finds the absolute pathes for all required classes and 
	 * includes them. Has to be called before the usage of any class in the
	 * framework. 
	 */
	public static function register() {
		spl_autoload_register(function ($class) {	
			$class = str_replace("core", "core".DIRECTORY_SEPARATOR."class", $class); 
			$file = BASEPATH.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';	
			
			if(file_exists($file)) { 
				require_once $file;
			}
		});
	}
}
?>