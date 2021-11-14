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

use Avolutions\Core\AbstractSingleton;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionMethod;

/**
 * Container class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class Container extends AbstractSingleton implements ContainerInterface
{
    protected array $resolvedEntries = [];

    private array $constructorParams = [];

    private array $interfaces = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->resolvedEntries[$id];
        }

        $entry = $this->resolveEntry($id);
        $this->resolvedEntries[$id] = $entry;

        return $entry;
    }

    /**
     * @param string $id
     * @param array $parameters
     * @return object
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     */
    public function make(string $id, array $parameters = []): object
    {
        $parameters = array_merge($this->constructorParams[$id] ?? [], $parameters);
        $entry = $this->resolveEntry($id, $parameters);

        $this->resolvedEntries[$id] = $entry;

        return $entry;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->resolvedEntries[$id]);
    }

    public function setConstructorParams($class, $params = [])
    {
        $this->constructorParams[$class] = $params;
    }

    public function setInterface($interface, $instance)
    {
        $this->interfaces[$interface] = $instance;
    }

    /**
     * TODO
     *
     * @param ReflectionMethod $Constructor
     * @param array $parameters
     * @return array
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     */
    public function getParameters(ReflectionMethod $Constructor, array $parameters = []): array
    {
        foreach ($Constructor->getParameters() as $parameter) {
            if (!isset($parameters[$parameter->getName()])) {
                $className = $parameter->getType()->getName();
                // TODO use has method?! Or add isResolvable method
                if (class_exists($className)) {
                    $parameters[$parameter->getName()] = $this->resolveEntry($className);
                }
            }
        }

        return $parameters;
    }

    /**
     * @param string $id
     * @return string
     */
    public function resolveInterface(string $id): string
    {
        if (isset($this->interfaces[$id])) {
            $id = $this->interfaces[$id];
        }

        return $id;
    }

    /**
     * @param mixed $id
     * @param array $parameters
     * @return object
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     */
    public function resolveEntry(mixed $id, array $parameters = []): object
    {
        $id = $this->resolveInterface($id);

        try {
            $ReflectionClass = new ReflectionClass($id);
        } catch (Exception) {
            throw new NotFoundException('TODO');
        }
        $Constructor = $ReflectionClass->getConstructor();

        if (!is_null($Constructor)) {
            $parameters = $this->getParameters($Constructor, $this->constructorParams[$id] ?? []);
        }

        return new $id(...$parameters);
    }
}
