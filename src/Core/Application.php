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

use Avolutions\Di\Container;
use Avolutions\Http\Request;
use Avolutions\Http\Response;
use Avolutions\Routing\Router;
use Avolutions\Util\JsonHelper;
use ReflectionException;

/**
 * Application class
 *
 * This class is responsible for path and namespace management of the Application.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class Application extends Container
{
    /**
     * The base path of your application.
     *
     * @var string
     */
    private string $basePath;

    /**
     * The application namespace.
     *
     * @var string
     */
    private string $appNamespace;

    /**
     * The name of the application folder.
     *
     * @var string
     */
    private string $appFolder = 'application';

    /**
     * __construct
     *
     * Creates a new Application instance.
     *
     * @param string $basePath The base path of your application.
     */
    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->appNamespace = $this->getAppNamespace();

        self::setInstance($this);
        $this->resolvedEntries[Container::class] = $this;
        $this->resolvedEntries[Application::class] = $this;
    }

    /**
     * getBasePath
     *
     * Returns the base path.
     *
     * @return string The base path.
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * getAppPath
     *
     * Returns the application path.
     *
     * @return string The application path.
     */
    public function getAppPath(): string
    {
        return $this->getBasePath() . $this->appFolder . DIRECTORY_SEPARATOR;
    }

    /**
     * getCommandPath
     *
     * Returns the path where Commands are stored.
     *
     * @return string The command path.
     */
    public function getCommandPath(): string
    {
        return $this->getAppPath() . 'Command' . DIRECTORY_SEPARATOR;
    }

    /**
     * getCommandTemplatePath
     *
     * Returns the path where Command templates are stored.
     *
     * @return string The command template path.
     */
    public function getCommandTemplatePath(): string
    {
        return $this->getAppPath() . 'Command' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
    }

    /**
     * getConfigPath
     *
     * Returns the path where config files are stored.
     *
     * @return string The config path.
     */
    public function getConfigPath(): string
    {
        return $this->getAppPath() . 'Config' . DIRECTORY_SEPARATOR;
    }

    /**
     * getControllerPath
     *
     * Returns the path where Controllers are stored.
     *
     * @return string The controller path.
     */
    public function getControllerPath(): string
    {
        return $this->getAppPath() . 'Controller' . DIRECTORY_SEPARATOR;
    }

    /**
     * getDatabasePath
     *
     * Returns the path where database migrations are stored.
     *
     * @return string The database path.
     */
    public function getDatabasePath(): string
    {
        return $this->getAppPath() . 'Database' . DIRECTORY_SEPARATOR;
    }

    /**
     * getEventPath
     *
     * Returns the path where Events are stored.
     *
     * @return string The event path.
     */
    public function getEventPath(): string
    {
        return $this->getAppPath() . 'Event' . DIRECTORY_SEPARATOR;
    }

    /**
     * getListenerPath
     *
     * Returns the path where Listeners are stored.
     *
     * @return string The listener path.
     */
    public function getListenerPath(): string
    {
        return $this->getAppPath() . 'Listener' . DIRECTORY_SEPARATOR;
    }

    /**
     * getMappingPath
     *
     * Returns the path where mapping files are stored.
     *
     * @return string The mapping path.
     */
    public function getMappingPath(): string
    {
        return $this->getAppPath() . 'Mapping' . DIRECTORY_SEPARATOR;
    }

    /**
     * getModelPath
     *
     * Returns the path where Models are stored.
     *
     * @return string The model path.
     */
    public function getModelPath(): string
    {
        return $this->getAppPath() . 'Model' . DIRECTORY_SEPARATOR;
    }

    /**
     * getTranslationPath
     *
     * Returns the path where translation files are stored.
     *
     * @return string The translation path.
     */
    public function getTranslationPath(): string
    {
        return $this->getAppPath() . 'Translation' . DIRECTORY_SEPARATOR;
    }

    /**
     * getValidatorPath
     *
     * Returns the path where Validators are stored.
     *
     * @return string The validator path.
     */
    public function getValidatorPath(): string
    {
        return $this->getAppPath() . 'Validator' . DIRECTORY_SEPARATOR;
    }

    /**
     * getViewPath
     *
     * Returns the path where Views are stored.
     *
     * @return string The view path.
     */
    public function getViewPath(): string
    {
        return $this->getAppPath() . 'View' . DIRECTORY_SEPARATOR;
    }

    /**
     * getAppNamespace
     *
     * Returns the namespace for your application by reading it from composer.json.
     *
     * @return string The application namespace.
     */
    private function getAppNamespace(): string
    {
        $composer = JsonHelper::decode($this->basePath . 'composer.json', true);

        foreach ($composer['autoload']['psr-4'] as $namespace => $path) {
            if (realpath($this->basePath . $path) === realpath($this->getAppPath())) {
                return $namespace;
            }
        }

        return 'Application\\';
    }

    /**
     * getCommandNamespace
     *
     * Returns the namespace for Command classes.
     *
     * @return string The command namespace.
     */
    public function getCommandNamespace(): string
    {
        return $this->appNamespace . 'Command\\';
    }

    /**
     * getControllerNamespace
     *
     * Returns the namespace for Controller classes.
     *
     * @return string The controller namespace.
     */
    public function getControllerNamespace(): string
    {
        return $this->appNamespace . 'Controller\\';
    }

    /**
     * getDatabaseNamespace
     *
     * Returns the namespace for Database Migration classes.
     *
     * @return string The database namespace.
     */
    public function getDatabaseNamespace(): string
    {
        return $this->appNamespace . 'Database\\';
    }


    /**
     * getEventNamespace
     *
     * Returns the namespace for Event classes.
     *
     * @return string The event namespace.
     */
    public function getEventNamespace(): string
    {
        return $this->appNamespace . 'Event\\';
    }

    /**
     * getListenerNamespace
     *
     * Returns the namespace for Listener classes.
     *
     * @return string The listener namespace.
     */
    public function getListenerNamespace(): string
    {
        return $this->appNamespace . 'Listener\\';
    }

    /**
     * getModelNamespace
     *
     * Returns the namespace for Model classes.
     *
     * @return string The model namespace.
     */
    public function getModelNamespace(): string
    {
        return $this->appNamespace . 'Model\\';
    }

    /**
     * getValidatorNamespace
     *
     * Returns the namespace for Validator classes.
     *
     * @return string The validator namespace.
     */
    public function getValidatorNamespace(): string
    {
        return $this->appNamespace . 'Validator\\';
    }

    /**
     * setErrorHandler
     *
     * Set error and exception handler for the Application.
     *
     * @throws ReflectionException
     */
    public function setErrorHandler()
    {
        $ErrorHandler = $this->get(ErrorHandler::class);
        set_error_handler([$ErrorHandler, 'handleError']);
        set_exception_handler([$ErrorHandler, 'handleException']);
    }

    /**
     * start
     *
     * Starts the Application by executing the Request, calling the Router to find the matching Route and
     * invokes the controller action with passed parameters.
     *
     * @throws ReflectionException
     */
    public function start(Request $Request)
    {
        $Router = $this->get(Router::class);
        $MatchedRoute = $Router->findRoute($Request->uri, $Request->method);

        $fullControllerName = $this->getControllerNamespace() . ucfirst($MatchedRoute->controllerName) . 'Controller';
        $Controller = $this->get($fullControllerName);

        $fullActionName = $MatchedRoute->actionName . 'Action';
        // Merge the parameters of the route with the values of $_REQUEST
        $parameters = array_merge($MatchedRoute->parameters, $Request->parameters);

        $Response = $this->get(Response::class);
        $Response->setBody(call_user_func_array([$Controller, $fullActionName], $parameters));
        $Response->send();
    }
}
