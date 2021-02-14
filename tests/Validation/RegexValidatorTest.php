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

use Avolutions\Validation\RegexValidator;

class RegexValidatorTest extends TestCase
{
    public function testMandatoryOptions() {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/']);
        $this->assertInstanceOf(RegexValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new RegexValidator();
    }

    public function testOptionPatternValidFormat() {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/']);
        $this->assertInstanceOf(RegexValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new RegexValidator(['pattern' => 123]);
    }

    public function testOptionNotValidFormat() {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/', 'not' => true]);
        $this->assertInstanceOf(RegexValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new RegexValidator(['pattern' => '/[a-z]/', 'not' => 123]);
    }

    public function testPatternIsValid() {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/']);

        $this->assertEquals($Validator->isValid('abc'), true);
        $this->assertEquals($Validator->isValid(123), false);
    }

    public function testPatternIsNotValid() {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/', 'not' => true]);

        $this->assertEquals($Validator->isValid('abc'), false);
        $this->assertEquals($Validator->isValid(123), true);
    }
}