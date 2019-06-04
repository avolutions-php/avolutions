<?php
/**
 * AVOLUTIONS
 * 
 * An open source PHP framework.
 * 
 * @package		AVOLUTIONS
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		http://framework.avolutions.de
 * @since		Version 1.0.0 * 
 */

namespace core;

/**
 * Autoloader class
 * 
 * Autoloads all required classes
 * 
 * @package		AVOLUTIONS
 * @subpackage	Core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/autoloader
 * @since		Version 1.0.0 * 
 */
class Autoloader {
	/**
	 * Includes all required files
	 * 
	 * This method finds the absolute pathes for all required classes and 
	 * includes them. Has to be called before the usage of any class in the
	 * framework. 
	 */
	public static function register() {
		spl_autoload_register(function ($class) {				
			$file = BASEPATH.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
					
			if(file_exists($file))
			{
				require_once($file);
			}
		});
	}
}
?>