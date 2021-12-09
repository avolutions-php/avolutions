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
 * Dependency Injection Container
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.9.0
 */
class Container extends AbstractSingleton implements ContainerInterface
{
    /**
     * Array to store resolved entries.
     *
     * @var array $resolvedEntries
     */
    protected array $resolvedEntries = [];

    /**
     * Array of parameters to resolve constructors with.
     *
     * @var array $parameters
     */
    private array $parameters = [];

    /**
     * To detect circular dependencies.
     *
     * @var array $currentlyResolvedEntries
     */
    private array $currentlyResolvedEntries = [];

    /**
     * Array to store/resolve aliases and interfaces.
     *
     * @var array $aliases
     */
    private array $aliases = [];

    /**
     * buildEntry
     *
     * Resolve all parameters and creates a new instance for the given entry.
     *
     * @param string $id Identifier of the entry to look for.
     * @param array|null $parameters Array of parameters to resolve entry with.
     *
     * @return mixed Instance of the resolved entry.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    private function buildEntry(string $id, ?array $parameters = null): mixed
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
     * get
     *
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Instance of the resolved entry.
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function get(string $id): mixed
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
     * Works like get(), but resolve the entry every time (create new instance).
     * Also, parameters can be passed to the constructor.
     *
     * @param string $id Identifier of the entry to look for.
     * @param array $parameters Array of parameters to pass to constructor, where key is name of parameter
     *
     * @return mixed Instance of the resolved entry.
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function make(string $id, array $parameters = []): mixed
    {
        return $this->resolveEntry($id, $parameters);
    }

    /**
     * resolveEntry
     *
     * Resolve an entry with the given parameters.
     *
     * @param mixed $id Identifier of the entry to look for.
     * @param array|null $parameters Array of parameters to resolve entry with.
     *
     * @return mixed The resolved entry.
     *
     * @throws ContainerException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function resolveEntry(mixed $id, ?array $parameters = null): mixed
    {
        if ($this->isAlias($id)) {
            $id = $this->resolveAlias($id);
        }

        if (isset($this->currentlyResolvedEntries[$id])) {
            throw new ContainerException(interpolate("Circular dependency detected while resolving '{0}'", [$id]));
        }
        $this->currentlyResolvedEntries[$id] = true;

        if ($this->has($id) && is_null($parameters)) {
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
     * Load the alias for the given entry.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Alias for the given entry.
     */
    private function resolveAlias(string $id): mixed
    {
        return $this->aliases[$id];
    }

    /**
     * isAlias
     *
     * Checks if an alias definition for entry exists.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool Weather an alias definition exists (true) or not (false).
     */
    private function isAlias(string $id): bool
    {
        return isset($this->aliases[$id]);
    }

    /**
     * resolveParameters
     *
     * Resolve parameters of the given constructor.
     *
     * @param string $id Identifier of the entry to look for.
     * @param ReflectionMethod $Constructor Constructor to resolve.
     * @param array|null $parameters Array of default values for parameters.
     *
     * @return array Array of resolved parameters.
     *
     * @throws ContainerException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function resolveParameters(string $id, ReflectionMethod $Constructor, ?array $parameters = null): array
    {
        if (is_null($parameters)) {
            $parameters = [];
        }

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
                // If parameter has no default value
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
     * set
     *
     * Set parameter values and alias definitions.
     *
     * @param string $name Name of the entry.
     * @param mixed $value Alias value or array of parameter values.
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
     * Returns name of the parameter or null if parameter is a builtin type.
     *
     * @param ReflectionParameter $parameter An function parameter.
     *
     * @return string|null Name of parameter or null if parameter is builtin type.
     */
    private function getParameterClassName(ReflectionParameter $parameter): ?string
    {
        $type = $parameter->getType();

        if ($type === null || $type->isBuiltin()) {
            return null;
        }

        return $parameter->getType()->getName();
    }
}
