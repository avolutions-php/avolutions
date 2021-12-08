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
 * JsonHelper class
 *
 * Provides helper methods to handle JSON.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class JsonHelper
{
    /**
     * decode
     *
     * Decodes a JSON string or a JSON file.
     *
     * @param string $jsonOrFilename Either a JSON string or the path to a JSON file.
     * @param bool $array When true, JSON will be returned as associative array. When false, JSON will be returned as object.
     *
     * @return mixed JSON as array or object.
     */
    public static function decode(string $jsonOrFilename, bool $array = false): mixed
    {
        if (file_exists($jsonOrFilename)) {
            return json_decode(file_get_contents($jsonOrFilename), $array);
        }

        return json_decode($jsonOrFilename, $array);
    }
}
