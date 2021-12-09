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

use Avolutions\Core\Application;

/**
 * Config class
 *
 * The Config class loads all config files at the bootstrapping and can be used to
 * get the config values anywhere in the framework or application.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class Config extends ConfigFileLoader
{
    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * __construct
     *
     * Creates a new Config instance and loads all config values from the config files of core and app.
     * The config values of the core are overridden by app config values.
     *
     * @param Application $Application Application instance.
     */
    public function __construct(Application $Application)
    {
        $this->Application = $Application;

        $coreConfigFiles = array_map('basename', glob($this->getConfigPath() . '*.php'));
        $appConfigFiles = array_map('basename', glob($this->Application->getConfigPath() . '*.php'));

        $configFiles = array_unique(array_merge($coreConfigFiles, $appConfigFiles));

        foreach ($configFiles as $configFile) {
            $coreConfigValues = $this->loadConfigFile($this->getConfigPath() . $configFile);
            $appConfigValues = $this->loadConfigFile($this->Application->getConfigPath() . $configFile);

            $configValues = array_merge($coreConfigValues, $appConfigValues);

            $this->values[pathinfo($configFile, PATHINFO_FILENAME)] = $configValues;
        }
    }

    /**
     * set
     *
     * Set the value for the given config key. The key is separated by slashes (/).
     *
     * @param string $key The config key (slash separated).
     * @param mixed $value The value to set.
     */
    public function set(string $key, mixed $value)
    {
        $identifiers = explode('/', $key);
        $values = &$this->values;

        foreach ($identifiers as $identifier) {
            if (!array_key_exists($identifier, $values)) {
                $values[$identifier] = [];
            }
            $values = &$values[$identifier];
        }

        $values = $value;
        unset($values);
    }

    /**
     * getConfigPath
     *
     * Returns the path to the core config files.
     *
     * @return string The core config path.
     */
    private function getConfigPath(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
    }
}