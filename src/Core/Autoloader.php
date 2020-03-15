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

namespace Avolutions\Core;

/**
 * Autoloader class
 * 
 * Autoloads all required classes
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Autoloader
{	
	/**
	 * register
	 * 
	 * This method finds the absolute pathes for all required classes and 
	 * includes them. Has to be called before the usage of any class in the
	 * framework. 
	 */
	public static function register() {
		spl_autoload_register(function ($class) {	
			$class = str_replace("Avolutions\\", "", $class); 
			
			$paths = array(
				SRC_PATH,
        		APP_CONTROLLER_PATH,
        		APP_MODEL_PATH,
	        	APP_VIEWMODEL_PATH
	        ); 
	        	        
	        foreach ($paths as $path) {
				$file = $path.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
				
				if(file_exists($file)) { 
					require_once $file;
					break;
				}
			}
		});
	}
}
?>