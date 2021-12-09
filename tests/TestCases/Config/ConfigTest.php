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

namespace Avolutions\Test\TestCases\Config;

use PHPUnit\Framework\TestCase;

use Avolutions\Config\Config;
use Avolutions\Core\Application;
use Avolutions\Logging\LogLevel;

class ConfigTest extends TestCase
{
    private Config $Config;

    public function setUp(): void
    {
        $Application = new Application(__DIR__);
        $this->Config = new Config($Application);
    }

    public function testDefaultApplicationConfigValuesCanBeRead()
    {
        $this->assertEquals('Y-m-d', $this->Config->get('application/defaultDateFormat'));
        $this->assertEquals('Y-m-d H:i:s', $this->Config->get('application/defaultDateTimeFormat'));
        $this->assertEquals('H:i:s', $this->Config->get('application/defaultTimeFormat'));
        $this->assertEquals('en', $this->Config->get('application/defaultLanguage'));
    }

    public function testDefaultDatabaseConfigValuesCanBeRead()
    {
        $this->assertEquals('127.0.0.1', $this->Config->get('database/host'));
        $this->assertEquals('avolutions', $this->Config->get('database/database'));
        $this->assertEquals('avolutions', $this->Config->get('database/user'));
        $this->assertEquals('avolutions', $this->Config->get('database/password'));
        $this->assertEquals('utf8', $this->Config->get('database/charset'));
        $this->assertEquals(false, $this->Config->get('database/migrateOnAppStart'));
    }

    public function testDefaultLoggerConfigValuesCanBeRead()
    {
        $this->assertEquals(LogLevel::DEBUG, $this->Config->get('logger/loglevel'));
        $this->assertEquals('logfile.log', $this->Config->get('logger/logfile'));
        $this->assertEquals('./log/', $this->Config->get('logger/logpath'));
        $this->assertEquals('Y-m-d H:i:s.v', $this->Config->get('logger/datetimeFormat'));
    }

    public function testConfigCanBeSetAndRead()
    {
        $this->Config->set('my/config/key', 4711);
        $this->assertEquals(4711, $this->Config->get('my/config/key'));
    }

    public function testConfigCanBeOverridden()
    {
        $this->Config->set('my/config/key', 4711);
        $this->assertEquals(4711, $this->Config->get('my/config/key'));
        $this->Config->set('my/config/key', 'foo');
        $this->assertEquals('foo', $this->Config->get('my/config/key'));
    }

    public function testGetConfigValueByHelper()
    {
        $configKey = 'application/defaultLanguage';

        $this->assertEquals(config($configKey), $this->Config->get($configKey));
        $this->assertEquals('en', config($configKey));
    }

    public function testSetConfigValueByHelper()
    {
        $configKey = 'foo/bar';

        config($configKey, 'baz');
        $this->assertEquals(config($configKey), application(Config::class)->get($configKey));
        $this->assertEquals('baz', config($configKey));

        config($configKey, 'HelloWorld');
        $this->assertEquals(config($configKey), application(Config::class)->get($configKey));
        $this->assertEquals('HelloWorld', config($configKey));
    }
}