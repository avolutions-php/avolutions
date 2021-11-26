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

namespace Avolutions\Test\TestCases\Validation;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use Avolutions\Validation\FormatValidator;

class FormatValidatorTest extends TestCase
{
    private string $validIp4 = '192.168.0.1';
    private string $invalidIp4 = '192.168.0.300';
    private string $validIp6 = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';
    private string $invalidIp6 = '2001:0db8:85a3:0000:0000:8a2e:0370:test';

    public function testMandatoryOptionsAreSet()
    {
        $this->expectException(InvalidArgumentException::class);
        new FormatValidator();
    }

    public function testOptionsValidFormat()
    {
        $validFormats = ['ip', 'ip4', 'ip6', 'mail', 'url', 'json'];
        foreach ($validFormats as $validFormat) {
            $Validator = new FormatValidator(['format' => $validFormat]);
            $this->assertInstanceOf(FormatValidator::class, $Validator);
        }

        $this->expectException(InvalidArgumentException::class);
        new FormatValidator(['format' => 'test']);
    }

    public function testIpIsValid()
    {
        $Validator = new FormatValidator(['format' => 'ip']);

        $this->assertEquals(true, $Validator->isValid($this->validIp4));
        $this->assertEquals(false, $Validator->isValid($this->invalidIp4));
        $this->assertEquals(true, $Validator->isValid($this->validIp6));
        $this->assertEquals(false, $Validator->isValid($this->invalidIp6));
    }

    public function testIp4IsValid()
    {
        $Validator = new FormatValidator(['format' => 'ip4']);

        $this->assertEquals(true, $Validator->isValid($this->validIp4));
        $this->assertEquals(false, $Validator->isValid($this->invalidIp4));
        $this->assertEquals(false, $Validator->isValid($this->validIp6));
        $this->assertEquals(false, $Validator->isValid($this->invalidIp6));
    }

    public function testIp6IsValid()
    {
        $Validator = new FormatValidator(['format' => 'ip6']);

        $this->assertEquals(false, $Validator->isValid($this->validIp4));
        $this->assertEquals(false, $Validator->isValid($this->invalidIp4));
        $this->assertEquals(true, $Validator->isValid($this->validIp6));
        $this->assertEquals(false, $Validator->isValid($this->invalidIp6));
    }

    public function testMailIsValid()
    {
        $Validator = new FormatValidator(['format' => 'mail']);

        $this->assertEquals(true, $Validator->isValid('alexander.vogt@avolutions.org'));
        $this->assertEquals(false, $Validator->isValid('alexander.vogt@avolutionsorg'));
        $this->assertEquals(false, $Validator->isValid('alexander.vogtavolutions.org'));
        $this->assertEquals(false, $Validator->isValid('@avolutions.org'));
    }

    public function testUrlIsValid()
    {
        $Validator = new FormatValidator(['format' => 'url']);

        $this->assertEquals(true, $Validator->isValid('https://avolutions.org'));
        $this->assertEquals(true, $Validator->isValid('https://avolutionsorg'));
        $this->assertEquals(false, $Validator->isValid('http:/avolutions.org'));
        $this->assertEquals(false, $Validator->isValid('avolutions.org'));
    }

    public function testJsonIsValid()
    {
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

        $Validator = new FormatValidator(['format' => 'json']);

        $this->assertEquals(true, $Validator->isValid($validJson));
        $this->assertEquals(false, $Validator->isValid($invalidJson));
    }
}