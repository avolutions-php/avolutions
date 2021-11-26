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
use ReflectionParameter;

/**
 * Container class
 *
 * TODO
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.9.0
 */
class Container extends AbstractSingleton implements ContainerInterface
{
    /**
     * TODO
     *
     * @var array $resolvedEntries
     */
    protected array $resolvedEntries = [];

    /**
     * TODO
     *
     * @var array $parameters
     */
    private array $parameters = [];

    /**
     * TODO
     *
     * @var array $currentlyResolvedEntries
     */
    private array $currentlyResolvedEntries = [];

    /**
     * TODO
     *
     * @var array $aliases
     */
    private array $aliases = [];

    /**
     * buildEntry
     *
     * TODO
     *
     * @param string $id TODO
     * @param array $parameters TODO
     *
     * @return mixed TODO
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    public function buildEntry(string $id, array $parameters): mixed
    {
        try {
            $ReflectionClass = new ReflectionClass($id);
        } catch (Exception) {
            throw new NotFoundException(interpolate("No entry was found for '{0}'.", [$id]));
        }
        $Constructor = $ReflectionClass->getConstructor();

        if (is_null($Constructor)) {
            return new $id;
        }

        $parameters = $this->resolveParameters($id, $Constructor, $parameters);

        return new $id(...$parameters);
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     */
    public function get(string $id)
    {
        return $this->resolveEntry($id);
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

    /**
     * make
     *
     * TODO
     *
     * @param string $id TODO
     * @param array $parameters TODO
     *
     * @return mixed TODO
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerException
     */
    public function make(string $id, array $parameters = []): mixed
    {
        return $this->resolveEntry($id, $parameters);
    }

    /**
     * resolveEntry
     *
     * TODO
     *
     * @param mixed $id TODO
     * @param array $parameters TODO
     *
     * @return mixed TODO
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerException TODO
     */
    public function resolveEntry(mixed $id, array $parameters = []): mixed
    {
        if ($this->isAlias($id)) {
            $id = $this->resolveAlias($id);
        }

        if (isset($this->currentlyResolvedEntries[$id])) {
            throw new ContainerException(interpolate("Circular dependency detected while resolving '{0}'", [$id]));
        }
        $this->currentlyResolvedEntries[$id] = true;

        if ($this->has($id)) {
            unset($this->currentlyResolvedEntries[$id]);
            return $this->resolvedEntries[$id];
        }

        $entry = $this->buildEntry($id, $parameters);
        $this->resolvedEntries[$id] = $entry;

        unset($this->currentlyResolvedEntries[$id]);

        return $entry;
    }

    /**
     * resolveAlias
     *
     * TODO
     *
     * @param string $id TODO
     *
     * @return string TODO
     */
    protected function resolveAlias(string $id): string
    {
        return $this->aliases[$id];
    }

    /**
     * isAlias
     *
     * TODO
     *
     * @param string $id TODO
     *
     * @return bool TODO
     */
    protected function isAlias(string $id): bool
    {
        return isset($this->aliases[$id]);
    }

    /**
     * resolveParameters
     *
     * TODO
     *
     * @param string $id TODO
     * @param ReflectionMethod $Constructor TODO
     * @param array $parameters TODO
     *
     * @return array TODO
     *
     * @throws NotFoundExceptionInterface No entry was found for **this** identifier.
     * @throws ContainerException TODO
     */
    public function resolveParameters(string $id, ReflectionMethod $Constructor, array $parameters = []): array
    {
        foreach ($Constructor->getParameters() as $parameter) {
            $parameterName = $parameter->name;

            // If parameter is passed from make method, use this parameter therefore nothing to do.
            if (isset($parameters[$parameterName])) {
                continue;
            }

            // If parameter is set as constructor parameter for entry, use this.
            if (isset($this->parameters[$id][$parameterName])) {
                $parameters[$parameterName] = $this->parameters[$id][$parameterName];
                continue;
            }

            // Check if parameter is resolvable (class) and resolve it, otherwise throw Exception.
            $parameterClassName = $this->getParameterClassName($parameter);
            if ($parameterClassName !== null) {
                $parameters[$parameter->getName()] = $this->resolveEntry($parameterClassName);
            } else {
                if (!$parameter->isDefaultValueAvailable()) {
                    throw new ContainerException(
                        interpolate(
                            "Parameter {0} of class {1} is either a builtin type or not typed and can therefore not be resolved.",
                            [$parameterName, $id]
                        )
                    );
                }
            }
        }

        return $parameters;
    }

    /**
     * setConstructorParams
     *
     * TODO
     *
     * @param string $name TODO
     * @param mixed $value TODO
     */
    public function set(string $name, mixed $value)
    {
        if (is_array($value)) {
            $this->parameters[$name] = $value;
        } else {
            $this->aliases[$name] = $value;
        }
    }

    /**
     * getParameterClassName
     *
     * TODO
     *
     * @param ReflectionParameter $parameter TODO
     *
     * @return string|null TODO
     */
    public function getParameterClassName(ReflectionParameter $parameter): ?string
    {
        $type = $parameter->getType();

        if ($type === null || $type->isBuiltin()) {
            return null;
        }

        return $parameter->getType()->getName();
    }
}
