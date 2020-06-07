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
        setcookie($Cookie->name, $Cookie->value);
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
        // TODO create Cookie object and return?
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