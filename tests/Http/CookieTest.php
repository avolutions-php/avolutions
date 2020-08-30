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

use PHPUnit\Framework\TestCase;

use Avolutions\Http\Cookie;

class CookieTest extends TestCase
{
    public function testCookieObjectCanBeCreated() 
    {
        $name = 'name';
        $value = 'value';
        $expires = 123;
        $path = 'path';
        $domain = 'domain';
        $secure = true;
        $httpOnly = true;

        $Cookie = new Cookie($name, $value, $expires, $path, $domain, $secure, $httpOnly);

        $this->assertEquals($Cookie->name, $name);
        $this->assertEquals($Cookie->value, $value);
        $this->assertEquals($Cookie->expires, $expires);
        $this->assertEquals($Cookie->path, $path);
        $this->assertEquals($Cookie->domain, $domain);
        $this->assertEquals($Cookie->secure, $secure);
        $this->assertEquals($Cookie->httpOnly, $httpOnly);
    }

    public function testCookieObjectDefaultValues() 
    {
        $name = 'name';
        $value = 'value';

        $Cookie = new Cookie($name, $value);

        $this->assertEquals($Cookie->name, $name);
        $this->assertEquals($Cookie->value, $value);
        $this->assertEquals($Cookie->expires, 0);
        $this->assertEquals($Cookie->path, '');
        $this->assertEquals($Cookie->domain, '');
        $this->assertEquals($Cookie->secure, false);
        $this->assertEquals($Cookie->httpOnly, false);
    }
}