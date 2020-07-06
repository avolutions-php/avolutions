<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2020 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */
 
namespace Avolutions\Http;

use Avolutions\Http\Cookie;

/**
 * CookieCollection class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.4.0
 */
class CookieCollection
{
    /**
	 * add
	 * 
	 * TODO
     * 
     * @param TODO
	 */
    public static function add($Cookie)
    {
        if (!$Cookie instanceof Cookie) {
            throw new \InvalidArgumentException('The passed parameter must be of type Cookie');
        }

        setcookie($Cookie->name, $Cookie->value, $Cookie->expires, $Cookie->path, $Cookie->domain, $Cookie->secure, $Cookie->httpOnly);
    }   

    /**
	 * get
	 * 
	 * TODO
     * 
     * @param TODO
     * 
     * @return TODO
	 */
    public static function get($name)
    {
        return $_COOKIE[$name] ?? null;
    }

    /**
	 * delete
	 * 
	 * TODO
     * 
     * @param TODO
	 */
    public static function delete($name)
    {
        unset($_COOKIE[$name]);
        setcookie($name, null, -1);
    }
}