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

use Avolutions\Database\Database;
use Avolutions\Di\Container;
use Avolutions\Http\Request;
use Avolutions\Http\Response;
use Avolutions\Logging\Logger;
use Avolutions\Routing\Router;
use Avolutions\Util\JsonHelper;
use PDO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
     * @var string $basePath
     */
    private string $basePath;

    /**
     * The application namespace.
     *
     * @var string $appNamespace
     */
    private string $appNamespace;

    /**
     * Default application paths.
     *
     * @var array $paths
     */
    private array $paths = [
        'app' => 'application',
        'command' => 'Command',
        'commandTemplate' => 'Command' . DIRECTORY_SEPARATOR . 'templates',
        'config' => 'Config',
        'controller' => 'Controller',
        'database' => 'Database',
        'event' => 'Event',
        'listener' => 'Listener',
        'mapping' => 'Mapping',
        'model' => 'Model',
        'translation' => 'Translation',
        'validator' => 'Validator',
        'view' => 'View',
    ];

    /**
     * Default application namespaces.
     *
     * @var array $namespaces
     */
    private array $namespaces = [
        'app' => 'Application',
        'command' => 'Command',
        'controller' => 'Controller',
        'database' => 'Database',
        'event' => 'Event',
        'listener' => 'Listener',
        'model' => 'Model',
        'validator' => 'Validator',
    ];

    /**
     * __construct
     *
     * Creates a new Application instance.
     *
     * @param string $basePath The base path of your application.
     */
    public function __construct(string $basePath, ?array $paths = [], ?array $namespaces = [])
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if (is_array($paths)) {
            $this->paths = array_merge($this->paths, $paths);
        }
        if (is_array($namespaces)) {
            $this->namespaces = array_merge($this->namespaces, $namespaces);
        }
        $this->appNamespace = $this->getAppNamespace();

        self::setInstance($this);
        $this->resolvedEntries[Container::class] = $this;
        $this->resolvedEntries[Application::class] = $this;

        $this->bootstrap();
    }

    /**
     * bootstrap
     *
     * Bootstraps the Application by setting Container objects.
     */
    private function bootstrap()
    {
        $this->set(
            Database::class,
            [
                'host' => config('database/host'),
                'database' => config('database/database'),
                'port' => config('database/port'),
                'user' => config('database/user'),
                'password' => config('database/password'),
                'charset' => config('database/charset'),
                'options' => [
                    PDO::ATTR_PERSISTENT => true
                ]
            ]
        );
        $this->set(
            Logger::class,
            [
                'logpath' => config('logger/logpath'),
                'logfile' => config('logger/logfile'),
                'minLogLevel' => config('logger/loglevel'),
                'datetimeFormat' => config('logger/datetimeFormat'),
            ]
        );
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
        return $this->getBasePath() . $this->formatPath($this->paths['app']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['command']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['commandTemplate']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['config']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['controller']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['database']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['event']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['listener']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['mapping']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['model']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['translation']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['validator']);
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
        return $this->getAppPath() . $this->formatPath($this->paths['view']);
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

        if (isset($composer['autoload']['psr-4'])) {
            foreach ($composer['autoload']['psr-4'] as $namespace => $path) {
                if (realpath($this->basePath . $path) === realpath($this->getAppPath())) {
                    return $namespace;
                }
            }
        }

        return $this->formatNamespace($this->namespaces['app']);
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
        return $this->appNamespace . $this->formatNamespace($this->namespaces['command']);
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
        return $this->appNamespace . $this->formatNamespace($this->namespaces['controller']);
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
        return $this->appNamespace . $this->formatNamespace($this->namespaces['database']);
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
        return $this->appNamespace . $this->formatNamespace($this->namespaces['event']);
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
        return $this->appNamespace . $this->formatNamespace($this->namespaces['listener']);
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
        return $this->appNamespace . $this->formatNamespace($this->namespaces['model']);
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
        return $this->appNamespace . $this->formatNamespace($this->namespaces['validator']);
    }

    /**
     * setErrorHandler
     *
     * Set error and exception handler for the Application.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
     * @param Request $Request Request instance.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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


    /**
     * formatPath
     *
     * Ensures that path ends with an OS specific directory separator.
     *
     * @param string $path A path to format.
     *
     * @return string Path with trailing directory separator.
     */
    private function formatPath(string $path): string
    {
        return rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
    }


    /**
     * formatNamespace
     *
     * Ensures that namespace ends with backslash.
     *
     * @param string $namespace A namespace to format.
     *
     * @return string Namespace with trailing backslash.
     */
    private function formatNamespace(string $namespace): string
    {
        return rtrim($namespace, '\\') . '\\';
    }
}
