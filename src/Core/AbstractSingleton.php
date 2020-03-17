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
 * Singleton class
 *
 * A abstract class which implements the singleton pattern.
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0

 */
abstract class AbstractSingleton
{
	/**
	 * @var array $instances An array of all instance of singleton classes
	 */
	private static $instances = [];
	
	/** 
	 * __construct
	 * 
	 * To prevent creating a new instance with the new operator
	 */
    final private function __construct()
    {

    }
	
	/**
	 * __clone
	 * 
	 * To prevent creating a instance with the clone operator
	 */
    final private function __clone()
    {

    }
	
	/**
	 * __wakeup
	 *
	 * To prevent unserializing a instance with unserialize function
	 */
    final private function __wakeup()
    {

    }
		
	/**
	 * getInstance
	 * 
	 * Creates a new instance of the class if there is no instance already and
	 * returns the newly created or existing instance.
	 * 
	 * @return object An object of the instantiated class
	 */
	final public static function getInstance()
	{
		$class = get_called_class();
				
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        
        return self::$instances[$class];
	}
}