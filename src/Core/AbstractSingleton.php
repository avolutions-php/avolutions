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
 * An abstract class which implements the singleton pattern.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
abstract class AbstractSingleton
{
    /**
     * An array of all instance of singleton classes
     *
     * @var array $instances
     */
    protected static array $instances = [];

    /**
     * getInstance
     *
     * Returns an instance of the called class.
     * If there is no instance so far, a new instance is created and returned.
     * Otherwise, the existing one is returned (singleton).
     *
     * @return object An object of the instantiated class
     */
    final public static function getInstance(): object
    {
        $class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::setInstance(new static());
        }

        return self::$instances[$class];
    }

    /**
     * setInstance
     *
     * Set the instance of the given class.
     *
     * @param mixed $class The class to set.
     */
    final public static function setInstance(mixed $class): void
    {
        self::$instances[$class::class] = $class;
    }
}