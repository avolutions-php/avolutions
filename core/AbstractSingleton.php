<?php
/**
 * AVOLUTIONS
 * 
 * An open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		http://framework.avolutions.de
 * @since		Version 1.0.0 
 */

namespace core;

/**
 * Singleton class
 *
 * A abstract class which implements the singleton pattern.
 * 
 * @package		avolutions\core
 * @subpackage	Core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/singleton
 * @since		Version 1.0.0
 */
abstract class AbstractSingleton
{
	/**
	 * @var array $instances An array of all instance of singleton classes
	 */
	private static $instances = array();
	
	/** 
	 * __construct
	 * 
	 * To prevent creating a new instance with the new operator
	 */
	private final function __construct() {}
	
	/**
	 * __clone
	 * 
	 * To prevent creating a instance with the clone operator
	 */
	private final function __clone() {}
	
	/**
	 * __wakeup
	 *
	 * To prevent unserializing a instance with unserialize function
	 */
	private final function __wakeup() {}
	
	
	/**
	 * getInstance
	 * 
	 * Creates a new instance of the class if there is no instance already and
	 * returns the newly created or existing instance.
	 * 
	 * @return object An object of the instantiated class
	 */
	public final static function getInstance()
	{
		$class = get_called_class();
				
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        
        return self::$instances[$class];
	}
}
?>