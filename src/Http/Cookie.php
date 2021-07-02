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

/**
 * Cookie class
 *
 * The Cookie class is an object representing a HTTP Cookie. This can be used to store information
 * on the client.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.4.0
 */
class Cookie
{
    /**
     * The (sub)domain that the cookie is available to.
     *
     * @var string $domain
     */
    public string $domain;

    /**
     * The time the cookie expires as UNIX timestamp.
     *
     * @var int $expires
     */
    public int $expires = 0;

    /**
     * Indicates if the cookie is only accessible through the HTTP protocol.
     *
     * @var bool $httpOnly
     */
    public bool $httpOnly = false;

    /**
     * The name of the cookie.
     *
     * @var string $name
     */
    public string $name;

    /**
     * The path on the server in which the cookie will be available on.
     *
     * @var string $path
     */
    public string $path;

    /**
     * Indicates if the cookie should only be transmitted over a secure HTTPS connection.
     *
     * @var bool $secure
     */
    public bool $secure = false;

    /**
     * The value of the cookie.
     *
     * @var string $value
     */
    public string $value;

    /**
     * __construct
     *
     * Creates a new Cookie object with the given parameters.
     *
     * @param string $name The name of the cookie.
     * @param string $value The value of the cookie.
     * @param int $expires The time the cookie expires as UNIX timestamp.
     * @param string $path The path on the server in which the cookie will be available on.
     * @param string $domain The (sub)domain that the cookie is available to.
     * @param bool $secure Indicates if the cookie should only be transmitted over a secure HTTPS connection.
     * @param bool $httpOnly Indicates if the cookie is only accessible through the HTTP protocol.
     */
    public function __construct(
        string $name,
        string $value,
        int $expires = 0,
        string $path = '',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = false
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
	}
}