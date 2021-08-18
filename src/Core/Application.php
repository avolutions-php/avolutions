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

use Avolutions\Util\JsonHelper;

/**
 * Application class
 *
 * This class is responsible for path and namespace management of the Application.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class Application extends AbstractSingleton
{
    /**
     * The base path of your application.
     *
     * @var string
     */
    private static string $basePath = '';

    /**
     * The application namespace.
     *
     * @var string
     */
    private static string $appNamespace = 'Application\\';

    /**
     * initialize
     *
     * Initializes the application.
     *
     * @param string $basePath The base path of your application.
     */
    public function initialize(string $basePath = '')
    {
        self::$basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        self::$appNamespace = self::getAppNamespace();
    }

    /**
     * getBasePath
     *
     * Returns the base path.
     *
     * @return string The base path.
     */
    public static function getBasePath(): string
    {
        return self::$basePath;
    }

    /**
     * getAppPath
     *
     * Returns the application path.
     *
     * @return string The application path.
     */
    public static function getAppPath(): string
    {
        return self::getBasePath() . 'application' . DIRECTORY_SEPARATOR;
    }

    /**
     * getCommandPath
     *
     * Returns the path where Commands are stored.
     *
     * @return string The command path.
     */
    public static function getCommandPath(): string
    {
        return self::getAppPath() . 'Command' . DIRECTORY_SEPARATOR;
    }

    /**
     * getCommandTemplatePath
     *
     * Returns the path where Command templates are stored.
     *
     * @return string The command template path.
     */
    public static function getCommandTemplatePath(): string
    {
        return self::getAppPath() . 'Command' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
    }

    /**
     * getConfigPath
     *
     * Returns the path where config files are stored.
     *
     * @return string The config path.
     */
    public static function getConfigPath(): string
    {
        return self::getAppPath() . 'Config' . DIRECTORY_SEPARATOR;
    }

    /**
     * getControllerPath
     *
     * Returns the path where Controllers are stored.
     *
     * @return string The controller path.
     */
    public static function getControllerPath(): string
    {
        return self::getAppPath() . 'Controller' . DIRECTORY_SEPARATOR;
    }

    /**
     * getDatabasePath
     *
     * Returns the path where database migrations are stored.
     *
     * @return string The database path.
     */
    public static function getDatabasePath(): string
    {
        return self::getAppPath() . 'Database' . DIRECTORY_SEPARATOR;
    }

    /**
     * getEventPath
     *
     * Returns the path where Events are stored.
     *
     * @return string The event path.
     */
    public static function getEventPath(): string
    {
        return self::getAppPath() . 'Event' . DIRECTORY_SEPARATOR;
    }

    /**
     * getListenerPath
     *
     * Returns the path where Listeners are stored.
     *
     * @return string The listener path.
     */
    public static function getListenerPath(): string
    {
        return self::getAppPath() . 'Listener' . DIRECTORY_SEPARATOR;
    }

    /**
     * getMappingPath
     *
     * Returns the path where mapping files are stored.
     *
     * @return string The mapping path.
     */
    public static function getMappingPath(): string
    {
        return self::getAppPath() . 'Mapping' . DIRECTORY_SEPARATOR;
    }

    /**
     * getModelPath
     *
     * Returns the path where Models are stored.
     *
     * @return string The model path.
     */
    public static function getModelPath(): string
    {
        return self::getAppPath() . 'Model' . DIRECTORY_SEPARATOR;
    }

    /**
     * getTranslationPath
     *
     * Returns the path where translation files are stored.
     *
     * @return string The translation path.
     */
    public static function getTranslationPath(): string
    {
        return self::getAppPath() . 'Translation' . DIRECTORY_SEPARATOR;
    }

    /**
     * getValidatorPath
     *
     * Returns the path where Validators are stored.
     *
     * @return string The validator path.
     */
    public static function getValidatorPath(): string
    {
        return self::getAppPath() . 'Validator' . DIRECTORY_SEPARATOR;
    }

    /**
     * getViewPath
     *
     * Returns the path where Views are stored.
     *
     * @return string The view path.
     */
    public static function getViewPath(): string
    {
        return self::getAppPath() . 'View' . DIRECTORY_SEPARATOR;
    }

    /**
     * getAppNamespace
     *
     * Returns the namespace for your application by reading it from composer.json.
     *
     * @return string The application namespace.
     */
    private static function getAppNamespace(): string
    {
        $composer = JsonHelper::decode(self::$basePath . 'composer.json', true);

        foreach ($composer["autoload"]["psr-4"] as $namespace => $path) {
            if (realpath(self::$basePath . $path) === realpath(self::getAppPath())) {
                return $namespace;
            }
        }
    }

    /**
     * getCommandNamespace
     *
     * Returns the namespace for Command classes.
     *
     * @return string The command namespace.
     */
    public static function getCommandNamespace(): string
    {
        return self::$appNamespace . 'Command\\';
    }

    /**
     * getControllerNamespace
     *
     * Returns the namespace for Controller classes.
     *
     * @return string The controller namespace.
     */
    public static function getControllerNamespace(): string
    {
        return self::$appNamespace . 'Controller\\';
    }

    /**
     * getDatabaseNamespace
     *
     * Returns the namespace for Database Migration classes.
     *
     * @return string The database namespace.
     */
    public static function getDatabaseNamespace(): string
    {
        return self::$appNamespace . 'Database\\';
    }


    /**
     * getEventNamespace
     *
     * Returns the namespace for Event classes.
     *
     * @return string The event namespace.
     */
    public static function getEventNamespace(): string
    {
        return self::$appNamespace . 'Event\\';
    }

    /**
     * getListenerNamespace
     *
     * Returns the namespace for Listener classes.
     *
     * @return string The listener namespace.
     */
    public static function getListenerNamespace(): string
    {
        return self::$appNamespace . 'Listener\\';
    }

    /**
     * getModelNamespace
     *
     * Returns the namespace for Model classes.
     *
     * @return string The model namespace.
     */
    public static function getModelNamespace(): string
    {
        return self::$appNamespace . 'Model\\';
    }

    /**
     * getValidatorNamespace
     *
     * Returns the namespace for Validator classes.
     *
     * @return string The validator namespace.
     */
    public static function getValidatorNamespace(): string
    {
        return self::$appNamespace . 'Validator\\';
    }
}
