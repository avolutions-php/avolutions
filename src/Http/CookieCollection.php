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

namespace Avolutions\Http;

use InvalidArgumentException;

/**
 * CookieCollection class
 *
 * The CookieCollection provides the functionality to store and retrieve
 * Cookie objects.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.4.0
 */
class CookieCollection
{
    /**
     * add
     *
     * Adds a new Cookie object. Will call the native php setcookie method.
     *
     * @param Cookie $Cookie The Cookie object to add.
     *
     * @throws InvalidArgumentException
     */
    public static function add(Cookie $Cookie)
    {
        setcookie($Cookie->name, $Cookie->value, $Cookie->expires, $Cookie->path, $Cookie->domain, $Cookie->secure, $Cookie->httpOnly);
    }

    /**
     * get
     *
     * Returns the value of a cookie by its name.
     *
     * @param string $name The name of the cookie.
     *
     * @return mixed The value of the cookie.
     */
    public static function get(string $name): mixed
    {
        return $_COOKIE[$name] ?? null;
    }

    /**
     * delete
     *
     * Deletes a cookie by its name.
     *
     * @param string $name The name of the cookie.
     */
    public static function delete(string $name)
    {
        unset($_COOKIE[$name]);
        setcookie($name, null, -1);
    }
}