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

namespace Avolutions\Config;

use OutOfBoundsException;

/**
 * ConfigFileLoader class
 *
 * The ConfigFileLoader class provides the functionality to load config files
 * from a given path and get single values from it.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.6.0
 */
class ConfigFileLoader
{
    /**
     * An array containing all loaded configuration values
     *
     * @var array $values
     */
    protected array $values = [];

    /**
     * get
     *
     * Returns the value for the given key. The key is separated by slashes (/).
     *
     * @param string $key The key (slash separated) of the config value.
     *
     * @return mixed The config value
     * @throws OutOfBoundsException
     */
    public function get(string $key): mixed
    {
        $identifier = explode('/', $key);

        $values = $this->values;

        foreach ($identifier as $value) {
            if (!isset($values[$value])) {
                throw new OutOfBoundsException('Key "' . $key . '" could not be found');
            }

            $values = $values[$value];
        }

        return $values;
    }

    /**
     * loadConfigFile
     *
     * Loads the given config file and return the content (array) or an empty array
     * if the file can not be found.
     *
     * @param string $configFile Complete name including the path and file extension of the config file.
     *
     * @return array An array with the loaded config values or an empty array if
     *                 file can not be found.
     */
    protected function loadConfigFile(string $configFile): array
    {
        if (file_exists($configFile)) {
            return require $configFile;
        }

        return [];
    }
}