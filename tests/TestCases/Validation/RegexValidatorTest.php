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

use Avolutions\Validation\RegexValidator;

class RegexValidatorTest extends TestCase
{
    public function testMandatoryOptions()
    {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/']);
        $this->assertInstanceOf(RegexValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RegexValidator();
    }

    public function testOptionPatternValidFormat()
    {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/']);
        $this->assertInstanceOf(RegexValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RegexValidator(['pattern' => 123]);
    }

    public function testOptionNotValidFormat()
    {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/', 'not' => true]);
        $this->assertInstanceOf(RegexValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RegexValidator(['pattern' => '/[a-z]/', 'not' => 123]);
    }

    public function testPatternIsValid()
    {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/']);

        $this->assertEquals(true, $Validator->isValid('abc'));
        $this->assertEquals(false, $Validator->isValid(123));
    }

    public function testPatternIsNotValid()
    {
        $Validator = new RegexValidator(['pattern' => '/[a-z]/', 'not' => true]);

        $this->assertEquals(false, $Validator->isValid('abc'));
        $this->assertEquals(true, $Validator->isValid(123));
    }
}