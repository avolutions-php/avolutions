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
 * Session class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.4.0
 */
class Session
{
    /**
	 * delete
	 * 
	 * TODO
     * 
     * @param TODO
	 */
    public static function delete($key)
    {
        Session::start();

        unset($_SESSION[$key]);
    }

    /**
	 * destroy
	 * 
	 * TODO
	 */
    public static function destroy()
    {
        Session::start();

        session_destroy();
        $_SESSION = [];
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
    public static function get($key)
    {
        Session::start();

        return $_SESSION[$key] ?? null;
    }

    /**
	 * set
	 * 
	 * TODO
     * 
     * @param TODO
     * @param TODO
	 */
    public static function set($key, $value)
    {
        Session::start();

        $_SESSION[$key] = $value;
    }

    /**
	 * start
	 * 
	 * TODO
	 */
    public static function start()
    {
        if (!Session::isStarted()) {
            session_start();
            $_SESSION = [];
        }
    }

    /**
	 * isStarted
	 * 
	 * TODO
     * 
     * @return TODO
	 */
    public static function isStarted()
    {
        return session_status() === \PHP_SESSION_ACTIVE; 
    }
}