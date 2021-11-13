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

use Avolutions\Command\CommandDispatcher;
use Avolutions\Core\Application;
use Avolutions\Util\StringHelper;
use Avolutions\Util\Translation;
use Avolutions\View\View;
use Avolutions\View\ViewModel;

/**
 * application
 *
 * Loads an instance from Container or returns the Application instance itself if not instance name is passed.
 *
 * @param string|null $instance Name of the instance to load from Container.
 *
 * @return object The loaded instance from Container or the Application instance.
 */
if (!function_exists('application')) {
    function application(?string $instance = null): object
    {
        if (!is_null($instance)) {
            return Application::getInstance()->get($instance);
        }

        return Application::getInstance();
    }
}

/**
 * interpolate
 *
 * Replaces placeholders in a string with given values.
 *
 * @param string $string String with placeholders.
 * @param array $params An array with values to replace the placeholders with.
 */
if (!function_exists('interpolate')) {
    function interpolate(string $string, array $params = []): string
    {
        return StringHelper::interpolate($string, $params);
    }
}

/**
 * translate
 *
 * Helper to load a translatable string.
 *
 * @param string $key The key of the translation string.
 * @param array $params An array with values to replace the placeholders in translation.
 * @param string|null $language The language in which the translation should be loaded.
 *
 * @throws Exception
 */
if (!function_exists('translate')) {
    function translate(string $key, array $params = [], ?string $language = null): string
    {
        return application(Translation::class)->getTranslation($key, $params, $language);
    }
}

/**
 * command
 *
 * Helper to dispatch a command.
 *
 * @param mixed $argv Command string or array with Arguments and Options.
 *
 * @return int Exit status.
 */
if (!function_exists('command')) {
    function command(mixed $argv): int
    {
        return application(CommandDispatcher::class)->dispatch($argv);
    }
}

/**
 * view
 *
 * Helper to create a new View.
 *
 * @param string|null $viewname The name of the View file.
 * @param ViewModel|null $ViewModel $ViewModel The ViewModel object that will be passed to the View.
 *
 * @return View A View instance.
 */
if (!function_exists('view')) {
    function view(?string $viewname = null, ?ViewModel $ViewModel = null): View
    {
        return application()->make(View::class, ['viewname' => $viewname, 'ViewModel' => $ViewModel]);
    }
}