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

namespace Avolutions\Test\Core;

use Avolutions\Core\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testDefaultApplicationPaths()
    {
        $Application = new Application(__DIR__);

        $basePath = __DIR__ . DIRECTORY_SEPARATOR;
        $appPath = $basePath . 'application' . DIRECTORY_SEPARATOR;

        $paths = [
            'base' => $basePath,
            'app' => $appPath,
            'command' => $appPath . 'Command' . DIRECTORY_SEPARATOR,
            'commandTemplate' => $appPath . 'Command' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
            'config' => $appPath . 'Config' . DIRECTORY_SEPARATOR,
            'controller' => $appPath . 'Controller' . DIRECTORY_SEPARATOR,
            'database' => $appPath . 'Database' . DIRECTORY_SEPARATOR,
            'event' => $appPath . 'Event' . DIRECTORY_SEPARATOR,
            'listener' => $appPath . 'Listener' . DIRECTORY_SEPARATOR,
            'mapping' => $appPath . 'Mapping' . DIRECTORY_SEPARATOR,
            'model' => $appPath . 'Model' . DIRECTORY_SEPARATOR,
            'translation' => $appPath . 'Translation' . DIRECTORY_SEPARATOR,
            'validator' => $appPath . 'Validator' . DIRECTORY_SEPARATOR,
            'view' => $appPath . 'View' . DIRECTORY_SEPARATOR,
        ];

        $this->assertEquals($paths['base'], $Application->getBasePath());
        $this->assertEquals($paths['app'], $Application->getAppPath());
        $this->assertEquals($paths['command'], $Application->getCommandPath());
        $this->assertEquals($paths['commandTemplate'], $Application->getCommandTemplatePath());
        $this->assertEquals($paths['config'], $Application->getConfigPath());
        $this->assertEquals($paths['controller'], $Application->getControllerPath());
        $this->assertEquals($paths['database'], $Application->getDatabasePath());
        $this->assertEquals($paths['event'], $Application->getEventPath());
        $this->assertEquals($paths['listener'], $Application->getListenerPath());
        $this->assertEquals($paths['mapping'], $Application->getMappingPath());
        $this->assertEquals($paths['model'], $Application->getModelPath());
        $this->assertEquals($paths['translation'], $Application->getTranslationPath());
        $this->assertEquals($paths['validator'], $Application->getValidatorPath());
        $this->assertEquals($paths['view'], $Application->getViewPath());
    }

    public function testDefaultApplicationNamespaces()
    {
        $Application = new Application(__DIR__);

        $appNamespace = 'Application\\';

        $namespaces = [
            'command' => $appNamespace . 'Command\\',
            'controller' => $appNamespace . 'Controller\\',
            'database' => $appNamespace . 'Database\\',
            'event' => $appNamespace . 'Event\\',
            'listener' => $appNamespace . 'Listener\\',
            'model' => $appNamespace . 'Model\\',
            'validator' => $appNamespace . 'Validator\\',
        ];

        $this->assertEquals($namespaces['command'], $Application->getCommandNamespace());
        $this->assertEquals($namespaces['controller'], $Application->getControllerNamespace());
        $this->assertEquals($namespaces['database'], $Application->getDatabaseNamespace());
        $this->assertEquals($namespaces['event'], $Application->getEventNamespace());
        $this->assertEquals($namespaces['listener'], $Application->getListenerNamespace());
        $this->assertEquals($namespaces['model'], $Application->getModelNamespace());
        $this->assertEquals($namespaces['validator'], $Application->getValidatorNamespace());
    }

    public function testApplicationPathsCanBeOverridden()
    {
        $customPaths = [
            'app' => 'app',
            'command' => 'CustomCommand',
            'commandTemplate' => 'CustomCommand' . DIRECTORY_SEPARATOR . 'templates',
            'config' => 'CustomConfig',
            'controller' => 'CustomController',
            'database' => 'CustomDatabase',
            'event' => 'CustomEvent',
            'listener' => 'CustomListener',
            'mapping' => 'CustomMapping',
            'model' => 'CustomModel',
            'translation' => 'CustomTranslation',
            'validator' => 'CustomValidator',
            'view' => 'CustomView',
        ];

        $Application = new Application(__DIR__, $customPaths);

        $basePath = __DIR__ . DIRECTORY_SEPARATOR;
        $appPath = $basePath . 'app' . DIRECTORY_SEPARATOR;

        $paths = [
            'base' => $basePath,
            'app' => $appPath,
            'command' => $appPath . $customPaths['command'] . DIRECTORY_SEPARATOR,
            'commandTemplate' => $appPath . $customPaths['commandTemplate'] . DIRECTORY_SEPARATOR,
            'config' => $appPath . $customPaths['config'] . DIRECTORY_SEPARATOR,
            'controller' => $appPath . $customPaths['controller'] . DIRECTORY_SEPARATOR,
            'database' => $appPath . $customPaths['database'] . DIRECTORY_SEPARATOR,
            'event' => $appPath . $customPaths['event'] . DIRECTORY_SEPARATOR,
            'listener' => $appPath . $customPaths['listener'] . DIRECTORY_SEPARATOR,
            'mapping' => $appPath . $customPaths['mapping'] . DIRECTORY_SEPARATOR,
            'model' => $appPath . $customPaths['model'] . DIRECTORY_SEPARATOR,
            'translation' => $appPath . $customPaths['translation'] . DIRECTORY_SEPARATOR,
            'validator' => $appPath . $customPaths['validator'] . DIRECTORY_SEPARATOR,
            'view' => $appPath . $customPaths['view'] . DIRECTORY_SEPARATOR,
        ];

        $this->assertEquals($paths['base'], $Application->getBasePath());
        $this->assertEquals($paths['app'], $Application->getAppPath());
        $this->assertEquals($paths['command'], $Application->getCommandPath());
        $this->assertEquals($paths['commandTemplate'], $Application->getCommandTemplatePath());
        $this->assertEquals($paths['config'], $Application->getConfigPath());
        $this->assertEquals($paths['controller'], $Application->getControllerPath());
        $this->assertEquals($paths['database'], $Application->getDatabasePath());
        $this->assertEquals($paths['event'], $Application->getEventPath());
        $this->assertEquals($paths['listener'], $Application->getListenerPath());
        $this->assertEquals($paths['mapping'], $Application->getMappingPath());
        $this->assertEquals($paths['model'], $Application->getModelPath());
        $this->assertEquals($paths['translation'], $Application->getTranslationPath());
        $this->assertEquals($paths['validator'], $Application->getValidatorPath());
        $this->assertEquals($paths['view'], $Application->getViewPath());
    }

    public function testApplicationNamespacesCanBeOverridden()
    {
        $customNamespaces = [
            'app' => 'App',
            'command' => 'CustomCommand',
            'controller' => 'CustomController',
            'database' => 'CustomDatabase',
            'event' => 'CustomEvent',
            'listener' => 'CustomListener',
            'model' => 'CustomModel',
            'validator' => 'CustomValidator',
        ];

        $Application = new Application(__DIR__, null, $customNamespaces);

        $appNamespace = 'App\\';

        $namespaces = [
            'command' => $appNamespace . $customNamespaces['command'] . '\\',
            'controller' => $appNamespace . $customNamespaces['controller'] . '\\',
            'database' => $appNamespace . $customNamespaces['database'] . '\\',
            'event' => $appNamespace . $customNamespaces['event'] . '\\',
            'listener' => $appNamespace . $customNamespaces['listener'] . '\\',
            'model' => $appNamespace . $customNamespaces['model'] . '\\',
            'validator' => $appNamespace . $customNamespaces['validator'] . '\\',
        ];

        $this->assertEquals($namespaces['command'], $Application->getCommandNamespace());
        $this->assertEquals($namespaces['controller'], $Application->getControllerNamespace());
        $this->assertEquals($namespaces['database'], $Application->getDatabaseNamespace());
        $this->assertEquals($namespaces['event'], $Application->getEventNamespace());
        $this->assertEquals($namespaces['listener'], $Application->getListenerNamespace());
        $this->assertEquals($namespaces['model'], $Application->getModelNamespace());
        $this->assertEquals($namespaces['validator'], $Application->getValidatorNamespace());
    }
}