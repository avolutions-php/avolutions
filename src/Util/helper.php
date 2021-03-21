<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

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
    function interpolate($string, $params = []) {
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
 * @param string $language The language in which the translation should be loaded.
 */
if (!function_exists('translate')) {
    function translate($key, $params = [], $language = null) {
        return Translation::getTranslation($key, $params, $language);
    }
}