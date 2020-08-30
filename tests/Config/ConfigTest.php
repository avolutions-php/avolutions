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

use Avolutions\Config\Config;
use Avolutions\Logging\LogLevel;

class ConfigTest extends TestCase
{
    public function testDefaultConfigValuesCanBeRead()
    {
        $this->assertEquals(Config::get("application/namespace"), "Application");

        $this->assertEquals(Config::get("database/host"), "127.0.0.1");
        $this->assertEquals(Config::get("database/database"), "avolutions");
        $this->assertEquals(Config::get("database/user"), "avolutions");
        $this->assertEquals(Config::get("database/password"), "avolutions");
        $this->assertEquals(Config::get("database/charset"), "utf8");
        $this->assertEquals(Config::get("database/migrateOnAppStart"), false);

        $this->assertEquals(Config::get("logger/loglevel"), LogLevel::DEBUG);
        $this->assertEquals(Config::get("logger/logfile"), "logfile.log");
        $this->assertEquals(Config::get("logger/logpath"), LOG_PATH);
        $this->assertEquals(Config::get("logger/datetimeFormat"), "Y-m-d H:i:s.v");
    }
}