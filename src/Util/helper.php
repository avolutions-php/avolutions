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
use Avolutions\Util\StringHelper;
use Avolutions\Util\Translation;

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
        return Translation::getTranslation($key, $params, $language);
    }
}

/**
 * command
 *
 * Helper to dispatch a command.
 *
 * @param mixed $argv Command string or array with arguments and Options.
 *
 * @return int Exit status.
 */
if (!function_exists('command')) {
    function command(mixed $argv): int
    {
        $CommandDispatcher = new CommandDispatcher();
        return $CommandDispatcher->dispatch($argv);
    }
}