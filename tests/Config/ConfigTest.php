<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

use PHPUnit\Framework\TestCase;

use Avolutions\Config\Config;

class ConfigTest extends TestCase
{
    public function testConfigCanBeSetAndRead()
    {
        Config::set('my/config/key', 4711);
        $this->assertEquals(4711, Config::get('my/config/key'));
    }

    public function testConfigCanBeOverridden()
    {
        Config::set('my/config/key', 4711);
        $this->assertEquals(4711, Config::get('my/config/key'));
        Config::set('my/config/key', 'foo');
        $this->assertEquals('foo', Config::get('my/config/key'));
    }
}