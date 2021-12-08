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

use const PHP_SESSION_ACTIVE;

/**
 * Session class
 *
 * The Session class provides functionality for the session handling.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.4.0
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
    public function delete(string $key)
    {
        $this->start();

        unset($_SESSION[$key]);
    }

    /**
     * destroy
     *
     * Destroys the session and unset all values.
     */
    public function destroy()
    {
        $this->start();

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
    public function get(string $key): mixed
    {
        $this->start();

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
    public function set(string $key, mixed $value)
    {
        $this->start();

        $_SESSION[$key] = $value;
    }

    /**
     * start
     *
     * Starts and initializes a new session.
     */
    public function start()
    {
        if (!$this->isStarted()) {
            session_start();
        }
    }

    /**
     * isStarted
     *
     * Checks if a session is already started.
     *
     * @return bool If the session is already started.
     */
    public function isStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }
}