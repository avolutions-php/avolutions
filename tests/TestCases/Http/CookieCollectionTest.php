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

use PHPUnit\Framework\TestCase;

use Avolutions\Http\Cookie;
use Avolutions\Http\CookieCollection;
use TypeError;

class CookieCollectionTest extends TestCase
{
    public function testCookieCanBeAddedToCollection()
    {
        $name = 'name';
        $value = 'value';

        $Cookie = new Cookie($name, $value);

        $this->assertNull(CookieCollection::add($Cookie));
    }

    public function testAddMethodThrowsExceptionOnWrongParameter()
    {
        $this->expectException(TypeError::class);

        CookieCollection::add(123);
    }

    public function testCookieCanBeReadFromCollection()
    {
        $value = CookieCollection::get('name');

        $this->assertEquals('value', $value);
    }

    public function testCookieCanBeDeletedFromCollection()
    {
        $this->assertNull(CookieCollection::delete('name'));
    }
}