<?php

use PHPUnit\Framework\TestCase;
use Avolutions\Config\Config;

class ConfigTest extends TestCase
{
    public function test_default_config_values_can_be_read()
    {
        $this->assertEquals(Config::get("database/host"), "127.0.0.1");
        $this->assertEquals(Config::get("database/user"), "avolutions");
        $this->assertEquals(Config::get("database/password"), "avolutions");
        $this->assertEquals(Config::get("database/charset"), "utf8");
        $this->assertEquals(Config::get("logger/debug"), true);
        $this->assertEquals(Config::get("logger/logfile"), "logfile.log");
        $this->assertEquals(Config::get("logger/logpath"), LOG_PATH);
        $this->assertEquals(Config::get("logger/datetimeFormat"), "Y-m-d H:i:s.v");
    }
}