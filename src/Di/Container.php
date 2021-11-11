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

namespace Avolutions\Di;

use ReflectionClass;

/**
 * Container class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class Container
{
    private $resolvedEntries = [];

    private $constructorParams = [];

    private $interfaces = [];

    public function __construct()
    {
        $this->resolvedEntries[get_class($this)] = $this;
    }

    /**
     * @throws \ReflectionException
     */
    public function get(string $id)
    {
        if (isset($this->resolvedEntries[$id])) {
            return $this->resolvedEntries[$id];
        }

        $parameters = [];

        if (isset($this->interfaces[$id])) {
            $id = $this->interfaces[$id];
        }

        $ReflectionClass = new ReflectionClass($id);
        $Constructor = $ReflectionClass->getConstructor();

        // class as no constructor
        if (!is_null($Constructor)) {
            foreach ($Constructor->getParameters() as $parameter) {
                if (isset($this->constructorParams[$id][$parameter->getName()])) {
                    $parameters[] = $this->constructorParams[$id][$parameter->getName()];
                } else {
                    $className = $parameter->getType()->getName();
                    // TODO use has method?! Or add isResolvable method
                    if (class_exists($className)) {
                        $parameters[] = $this->get($className);
                    }
                }
            }
        }

        $entry = new $id(...$parameters);

        $this->resolvedEntries[$id] = $entry;

        return $entry;
    }

    public function has(string $id): bool
    {
        return true;
    }

    public function setConstructorParams($class, $params = [])
    {
        $this->constructorParams[$class] = $params;
    }

    public function setInterface($interface, $instance)
    {
        $this->interfaces[$interface] = $instance;
    }
}
