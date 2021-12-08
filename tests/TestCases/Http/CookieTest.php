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

namespace Avolutions\Test\TestCases\Http;

use Avolutions\Core\Application;
use PHPUnit\Framework\TestCase;

use Avolutions\Http\Cookie;

class CookieTest extends TestCase
{
    public function setUp(): void
    {
        new Application(__DIR__);
    }

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
        $CookieByHelper = cookie($name, $value, $expires, $path, $domain, $secure, $httpOnly);

        $this->assertEquals($Cookie, $CookieByHelper);

        $this->assertEquals($name, $Cookie->name);
        $this->assertEquals($value, $Cookie->value);
        $this->assertEquals($expires, $Cookie->expires);
        $this->assertEquals($path, $Cookie->path);
        $this->assertEquals($domain, $Cookie->domain);
        $this->assertEquals($secure, $Cookie->secure);
        $this->assertEquals($httpOnly, $Cookie->httpOnly);
    }

    public function testCookieObjectDefaultValues()
    {
        $name = 'name';
        $value = 'value';

        $Cookie = new Cookie($name, $value);
        $CookieByHelper = cookie($name, $value);

        $this->assertEquals($Cookie, $CookieByHelper);

        $this->assertEquals($name, $Cookie->name);
        $this->assertEquals($value, $Cookie->value);
        $this->assertEquals(0, $Cookie->expires);
        $this->assertEquals('', $Cookie->path);
        $this->assertEquals('', $Cookie->domain);
        $this->assertEquals(false, $Cookie->secure);
        $this->assertEquals(false, $Cookie->httpOnly);
    }
}