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
 * Application class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class Application extends AbstractSingleton
{
    // TODO idea: add bool parameter to getter to add DIRECTORY_SEPERATOR (default) or not to end of path
    // TODO change to protected to allow users to redefined by extending/override Application class with DI
    // TODO if paths are set by developer then return in getter methods
    private static string $basePath;
    private string $appPath;
    private string $commandPath;
    private string $configPath;
    private string $databasePath; // TODO change to migration?
    private string $mappingPath;
    private string $translationPath;
    private string $viewPath;

    // TODO add variables for namespaces to provide override
    private static string $appNamespace;
    protected static string $commandNamespace;
    protected static string $controllerNamespace;
    protected static string $databaseNamespace;
    protected static string $listenerNamespace;
    protected static string $modelNamespace;
    protected static string $validatorNamespace;


    /**
     * @return string
     */
    public static function getCommandNamespace(): string
    {
        return self::$appNamespace.'Command\\';
    }

    public static function getControllerNamespace(): string
    {
        return self::$appNamespace.'Controller\\';
    }

    public static function getDatabaseNamespace(): string
    {
        return self::$appNamespace.'Database\\';
    }

    public static function getListenerNamespace(): string
    {
        return self::$appNamespace.'Listener\\';
    }

    public static function getModelNamespace(): string
    {
        return self::$appNamespace.'Model\\';
    }

    public static function getValidatorNamespace(): string
    {
        return self::$appNamespace.'Validator\\';
    }

    private static function getAppNamespace(): string
    {
        $composer = json_decode(file_get_contents(self::$basePath.'composer.json'), true);

        foreach ($composer["autoload"]["psr-4"] as $namespace => $path) {
            if (realpath(self::$basePath.$path) === realpath(self::getAppPath())) {
                return $namespace;
            }
        }
    }

    /**
     * Application constructor.
     *
     * @param string $basePath
     */
    public function initialize(string $basePath = '')
    {
        // TODO check passed basePath and add DIRECTORY_SEPERATOR to end if not there
        self::$basePath = $basePath.DIRECTORY_SEPARATOR;
        self::$appNamespace = self::getAppNamespace();
    }


    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return self::$basePath;
    }

    /**
     * @return string
     */
    public static function getAppPath(): string
    {
        return self::$basePath.'application'.DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public static function getCommandPath(): string
    {
        return self::getAppPath().'Command'.DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public static function getConfigPath(): string
    {
        return self::getAppPath().'Config'.DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public static function getDatabasePath(): string
    {
        return self::getAppPath().'Database'.DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public static function getMappingPath(): string
    {
        return self::getAppPath().'Mapping'.DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public static function getTranslationPath(): string
    {
        return self::getAppPath().'Translation'.DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public static function getViewPath(): string
    {
        return self::getAppPath().'View'.DIRECTORY_SEPARATOR;
    }
}