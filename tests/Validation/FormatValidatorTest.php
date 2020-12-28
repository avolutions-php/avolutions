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

use Avolutions\Validation\Validator\FormatValidator;

class FormatValidatorTest extends TestCase
{
    private $validIp4 = '192.168.0.1';
    private $invalidIp4 = '192.168.0.300';
    private $validIp6 = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';
    private $invalidIp6 = '2001:0db8:85a3:0000:0000:8a2e:0370:test';

    public function testIpIsValid() {
        $Validator = new FormatValidator('ip');
        $this->assertEquals($Validator->isValid($this->validIp4), true);
        $this->assertEquals($Validator->isValid($this->invalidIp4), false);
        $this->assertEquals($Validator->isValid($this->validIp6), true);
        $this->assertEquals($Validator->isValid($this->invalidIp6), false);
    }

    public function testIp4IsValid() {
        $Validator = new FormatValidator('ip4');
        $this->assertEquals($Validator->isValid($this->validIp4), true);
        $this->assertEquals($Validator->isValid($this->invalidIp4), false);
        $this->assertEquals($Validator->isValid($this->validIp6), false);
        $this->assertEquals($Validator->isValid($this->invalidIp6), false);
    }

    public function testIp6IsValid() {
        $Validator = new FormatValidator('ip6');
        $this->assertEquals($Validator->isValid($this->validIp4), false);
        $this->assertEquals($Validator->isValid($this->invalidIp4), false);
        $this->assertEquals($Validator->isValid($this->validIp6), true);
        $this->assertEquals($Validator->isValid($this->invalidIp6), false);
    }

    public function testMailIsValid() {
        $Validator = new FormatValidator('mail');
        $this->assertEquals($Validator->isValid('alexander.vogt@avolutions.org'), true);
        $this->assertEquals($Validator->isValid('alexander.vogt@avolutionsorg'), false);
        $this->assertEquals($Validator->isValid('alexander.vogtavolutions.org'), false);
        $this->assertEquals($Validator->isValid('@avolutions.org'), false);
    }

    public function testUrlIsValid() {
        $Validator = new FormatValidator('url');
        $this->assertEquals($Validator->isValid('https://avolutions.org'), true);
        $this->assertEquals($Validator->isValid('https://avolutionsorg'), true);
        $this->assertEquals($Validator->isValid('http:/avolutions.org'), false);
        $this->assertEquals($Validator->isValid('avolutions.org'), false);
    }

    public function testJsonIsValid() {
        $validJson = '{"menu": {
            "id": "file",
            "value": "File",
            "popup": {
              "menuitem": [
                {"value": "New", "onclick": "CreateNewDoc()"},
                {"value": "Open", "onclick": "OpenDoc()"},
                {"value": "Close", "onclick": "CloseDoc()"}
              ]
            }
          }}';

        $invalidJson = '{"menu": {
            "id": "file",
            "value": "File",
            "popup": {
              "menuitem": [
                {"value": "New", "onclick": "CreateNewDoc()"},
                {"value": "Open", "onclick": "OpenDoc()"},
                {"value": "Close", "onclick": "CloseDoc()"}
              ]
            }
          }';  

        $Validator = new FormatValidator('json');
        $this->assertEquals($Validator->isValid($validJson), true);
        $this->assertEquals($Validator->isValid($invalidJson), false);
    }
}