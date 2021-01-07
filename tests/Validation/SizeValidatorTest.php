<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright	Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */

use PHPUnit\Framework\TestCase;

use Avolutions\Validation\SizeValidator;

class SizeValidatorTest extends TestCase
{
    public function testMandatoryOptionsAreSet() {
        $Validator = new SizeValidator(['size' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $Validator = new SizeValidator(['min' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $Validator = new SizeValidator(['max' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new SizeValidator();
    }

    public function testOptionSizeValidFormat() {
        $Validator = new SizeValidator(['size' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new SizeValidator(['size' => '12']);
    }

    public function testOptionMinValidFormat() {
        $Validator = new SizeValidator(['min' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new SizeValidator(['min' => 'test']);
    }

    public function testOptionMaxValidFormat() {
        $Validator = new SizeValidator(['max' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new SizeValidator(['max' => 'test']);
    }

    public function testSizeIsValid() {
        $Validator = new SizeValidator(['size' => 4]);

        // string
        $this->assertEquals($Validator->isValid(''), false);
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid('testt'), false);

        // int
        $this->assertEquals($Validator->isValid(0), false);
        $this->assertEquals($Validator->isValid(4), true);
        $this->assertEquals($Validator->isValid(5), false);

        // array
        $this->assertEquals($Validator->isValid([]), false);
        $this->assertEquals($Validator->isValid([1,2,3,4]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4,5]), false);

        // invalid types
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(false), false);
    }

    public function testMinIsValid() {
        $Validator = new SizeValidator(['min' => 1]);

        // string
        $this->assertEquals($Validator->isValid(''), false);
        $this->assertEquals($Validator->isValid('t'), true);
        $this->assertEquals($Validator->isValid('test'), true);

        // int
        $this->assertEquals($Validator->isValid(0), false);
        $this->assertEquals($Validator->isValid(1), true);
        $this->assertEquals($Validator->isValid(4), true);

        // array
        $this->assertEquals($Validator->isValid([]), false);
        $this->assertEquals($Validator->isValid([1]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4]), true);

        // invalid types
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(false), false);
    }

    public function testMaxIsValid() {
        $Validator = new SizeValidator(['max' => 4]);

        // string
        $this->assertEquals($Validator->isValid(''), true);
        $this->assertEquals($Validator->isValid('t'), true);
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid('testt'), false);

        // int
        $this->assertEquals($Validator->isValid(0), true);
        $this->assertEquals($Validator->isValid(1), true);
        $this->assertEquals($Validator->isValid(4), true);
        $this->assertEquals($Validator->isValid(5), false);

        // array
        $this->assertEquals($Validator->isValid([]), true);
        $this->assertEquals($Validator->isValid([1]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4,5]), false);

        // invalid types
        $this->assertEquals($Validator->isValid(null), true);
        $this->assertEquals($Validator->isValid(false), true);
    }

    public function testMinAndMaxIsValid() {
        $Validator = new SizeValidator(['min' => 1, 'max' => 4]);

        // string
        $this->assertEquals($Validator->isValid(''), false);
        $this->assertEquals($Validator->isValid('t'), true);
        $this->assertEquals($Validator->isValid('tes'), true);
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid('testt'), false);

        // int
        $this->assertEquals($Validator->isValid(0), false);
        $this->assertEquals($Validator->isValid(1), true);
        $this->assertEquals($Validator->isValid(3), true);
        $this->assertEquals($Validator->isValid(4), true);
        $this->assertEquals($Validator->isValid(5), false);

        // array
        $this->assertEquals($Validator->isValid([]), false);
        $this->assertEquals($Validator->isValid([1]), true);
        $this->assertEquals($Validator->isValid([1,2,3]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4,5]), false);

        // invalid types
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(false), false);
    }

    public function testSizeAsDefaultIsValid() {
        // Test if 'size' is used if 'size' and 'min/max' are specified
        $Validator = new SizeValidator(['size' => 3, 'min' => 1, 'max' => 4]);

        // string
        $this->assertEquals($Validator->isValid(''), false);
        $this->assertEquals($Validator->isValid('t'), false);
        $this->assertEquals($Validator->isValid('tes'), true);
        $this->assertEquals($Validator->isValid('test'), false);
        $this->assertEquals($Validator->isValid('testt'), false);

        // int
        $this->assertEquals($Validator->isValid(0), false);
        $this->assertEquals($Validator->isValid(1), false);
        $this->assertEquals($Validator->isValid(3), true);
        $this->assertEquals($Validator->isValid(4), false);
        $this->assertEquals($Validator->isValid(5), false);

        // array
        $this->assertEquals($Validator->isValid([]), false);
        $this->assertEquals($Validator->isValid([1]), false);
        $this->assertEquals($Validator->isValid([1,2,3]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4]), false);
        $this->assertEquals($Validator->isValid([1,2,3,4,5]), false);

        // invalid types
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(false), false);
    }
}