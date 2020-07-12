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
 * Cookie class
 *
 * The Cookie class is an object represeting a HTTP Cookie. This can be used to store information
 * on the client. 
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.4.0
 */
class Cookie
{	
    /** 
     * @var string $domain The (sub)domain that the cookie is available to.
     */
    public $domain = '';

    /** 
     * @var int $expires The time the cookie expires as UNIX timestamp.
     */
    public $expires = 0;

    /** 
     * @var bool $httpOnly Indicates if the cookie is only accessible through the HTTP protocol.
     */
    public $httpOnly = false;

    /** 
     * @var string $name The name of the cookie.
     */
    public $name;

    /** 
     * @var string $path The path on the server in which the cookie will be available on.
     */
    public $path = '';

    /** 
     * @var bool $secure Indicates if the cookie should only be transmitted over a secure HTTPS connection.
     */
    public $secure = false;

    /** 
     * @var string $value The value of the cookie.
     */
    public $value = '';

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
    public function __construct($name, $value, $expires = 0, $path = '', $domain = '', $secure = false, $httpOnly = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
	}	
}