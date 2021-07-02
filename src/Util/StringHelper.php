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

namespace Avolutions\Util;

/**
 * StringHelper class
 *
 * Provides helper methods to handle strings.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class StringHelper
{
    /**
     * interpolate
     *
     * Replaces placeholders in a string with given values.
     *
     * @param string $string String with placeholders.
     * @param array $params An array with values to replace the placeholders with.
     *
     * @return string String with replaced values.
     */
    public static function interpolate(string $string, array $params = []): string
    {
        if (is_array($params) && count($params) > 0) {
            foreach ($params as $paramKey => $paramValue) {
                $string = str_replace('{'.$paramKey.'}', $paramValue, $string);
            }
        }

        return $string;
    }
}