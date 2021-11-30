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
use Avolutions\Config\Config;
use Avolutions\Core\Application;
use Avolutions\Http\Cookie;
use Avolutions\Util\StringHelper;
use Avolutions\Util\Translation;
use Avolutions\View\View;
use Avolutions\View\ViewModel;

/**
 * application
 *
 * Loads an instance from Container or returns the Application instance itself if no instance name is passed.
 *
 * @param string|null $instance Name of the instance to load from Container.
 * @param array|null $values Array of parameters to pass to constructor, where key is name of parameter.
 *
 * @return mixed The loaded instance from Container or the Application instance.
 */
if (!function_exists('application')) {
    function application(?string $instance = null, ?array $values = null): mixed
    {
        if (!is_null($instance)) {
            if (is_array($values)) {
                return Application::getInstance()->make($instance, $values);
            }

            return Application::getInstance()->get($instance);
        }

        return Application::getInstance();
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
 * config
 *
 * Helper to get or set a config value.
 *
 * @param string $key The config key (slash separated).
 * @param mixed $value The value to set.
 *
 * @return mixed The config value
 */
if (!function_exists('config')) {
    function config(string $key, mixed $value = null): mixed
    {
        if (!is_null($value)) {
            application(Config::class)->set($key, $value);
        }

        return application(Config::class)->get($key);
    }
}

/**
 * cookie
 *
 * Creates a new Cookie object with the given parameters.
 *
 * @param string $name The name of the cookie.
 * @param string $value The value of the cookie.
 * @param int $expires The time the cookie expires as UNIX timestamp.
 * @param string $path The path on the server in which the cookie will be available on.
 * @param string $domain The (sub)domain that the cookie is available to.
 * @param bool $secure Indicates if the cookie should only be transmitted over a secure HTTPS connection.
 * @param bool $httpOnly Indicates if the cookie is only accessible through the HTTP protocol.
 *
 * @return Cookie The Cookie object.
 */
if (!function_exists('cookie')) {
    function cookie(
        string $name,
        string $value,
        int $expires = 0,
        string $path = '',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = false
    ): Cookie {
        return application()->make(Cookie::class, [
            'name' => $name,
            'value' => $value,
            'expires' => $expires,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly
        ]);
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