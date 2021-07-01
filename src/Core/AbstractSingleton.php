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
     * An array of all instance of singleton classes
     *
	 * @var array $instances
	 */
	private static array $instances = [];

	/**
	 * __construct
	 *
	 * To prevent creating an new instance with the new operator
	 */
    final public function __construct()
    {

    }

	/**
	 * __clone
	 *
	 * To prevent creating an instance with the clone operator
	 */
    final public function __clone()
    {

    }

	/**
	 * __wakeup
	 *
	 * To prevent unserializing an instance with unserialize function
	 */
    final public function __wakeup()
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
	final public static function getInstance(): object
    {
		$class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
	}
}