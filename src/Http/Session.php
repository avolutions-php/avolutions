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
 * The Session class provides functionality for the session handling.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.4.0
 */
class Session
{
    /**
	 * delete
	 * 
	 * Deletes a session value by its key.
     * 
     * @param string $key The key of the session value.
	 */
    public static function delete($key)
    {
        Session::start();

        unset($_SESSION[$key]);
    }

    /**
	 * destroy
	 * 
	 * Destroys the session and unset all values.
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
	 * Returns a session value by its key.
     * 
     * @param string $key The key of the session value.
     * 
     * @return mixed The value of the session entry.
	 */
    public static function get($key)
    {
        Session::start();

        return $_SESSION[$key] ?? null;
    }

    /**
	 * set
	 * 
	 * Set a new session value.
     * 
     * @param string $key The key of the session value.
     * @param mixed $value The value to store.
	 */
    public static function set($key, $value)
    {
        Session::start();

        $_SESSION[$key] = $value;
    }

    /**
	 * start
	 * 
	 * Starts and initializes a new session. 
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
	 * Checks if a session is already started.
     * 
     * @return bool If the session is already started.
	 */
    public static function isStarted()
    {
        return session_status() === \PHP_SESSION_ACTIVE; 
    }
}