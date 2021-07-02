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

use PHPUnit\Framework\TestCase;

use Avolutions\Config\Config;
use Avolutions\Logging\LogLevel;

class ConfigTest extends TestCase
{
    public function setUp(): void
    {
        $Config = Config::getInstance();
        $Config->initialize();
    }

    public function testDefaultApplicationConfigValuesCanBeRead()
    {
        $this->assertEquals('Y-m-d', Config::get('application/defaultDateFormat'));
        $this->assertEquals('Y-m-d H:i:s', Config::get('application/defaultDateTimeFormat'));
        $this->assertEquals('H:i:s', Config::get('application/defaultTimeFormat'));
        $this->assertEquals('en', Config::get('application/defaultLanguage'));
        $this->assertEquals('Application', Config::get('application/namespace'));
    }

    public function testDefaultDatabaseConfigValuesCanBeRead()
    {
        $this->assertEquals('127.0.0.1', Config::get('database/host'));
        $this->assertEquals('avolutions', Config::get('database/database'));
        $this->assertEquals('avolutions', Config::get('database/user'));
        $this->assertEquals('avolutions', Config::get('database/password'));
        $this->assertEquals('utf8', Config::get('database/charset'));
        $this->assertEquals(false, Config::get('database/migrateOnAppStart'));
    }

    public function testDefaultLoggerConfigValuesCanBeRead()
    {
        $this->assertEquals(LogLevel::DEBUG, Config::get('logger/loglevel'));
        $this->assertEquals('logfile.log', Config::get('logger/logfile'));
        $this->assertEquals('./log/', Config::get('logger/logpath'));
        $this->assertEquals('Y-m-d H:i:s.v', Config::get('logger/datetimeFormat'));
    }

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