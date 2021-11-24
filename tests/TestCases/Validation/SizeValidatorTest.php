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

use Avolutions\Validation\SizeValidator;

class SizeValidatorTest extends TestCase
{
    public function testMandatoryOptionsAreSet()
    {
        $Validator = new SizeValidator(['size' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $Validator = new SizeValidator(['min' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $Validator = new SizeValidator(['max' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new SizeValidator();
    }

    public function testOptionSizeValidFormat()
    {
        $Validator = new SizeValidator(['size' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new SizeValidator(['size' => '12']);
    }

    public function testOptionMinValidFormat()
    {
        $Validator = new SizeValidator(['min' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new SizeValidator(['min' => 'test']);
    }

    public function testOptionMaxValidFormat()
    {
        $Validator = new SizeValidator(['max' => 12]);
        $this->assertInstanceOf(SizeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new SizeValidator(['max' => 'test']);
    }

    public function testSizeIsValid()
    {
        $Validator = new SizeValidator(['size' => 4]);

        // string
        $this->assertEquals(false, $Validator->isValid(''));
        $this->assertEquals(true, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid('testt'));

        // int
        $this->assertEquals(false, $Validator->isValid(0));
        $this->assertEquals(true, $Validator->isValid(4));
        $this->assertEquals(false, $Validator->isValid(5));

        // array
        $this->assertEquals(false, $Validator->isValid([]));
        $this->assertEquals(true, $Validator->isValid([1, 2, 3, 4]));
        $this->assertEquals(false, $Validator->isValid([1, 2, 3, 4, 5]));

        // invalid types
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(false));
    }

    public function testMinIsValid()
    {
        $Validator = new SizeValidator(['min' => 1]);

        // string
        $this->assertEquals(false, $Validator->isValid(''));
        $this->assertEquals(true, $Validator->isValid('t'));
        $this->assertEquals(true, $Validator->isValid('test'));

        // int
        $this->assertEquals(false, $Validator->isValid(0));
        $this->assertEquals(true, $Validator->isValid(1));
        $this->assertEquals(true, $Validator->isValid(4));

        // array
        $this->assertEquals(false, $Validator->isValid([]));
        $this->assertEquals(true, $Validator->isValid([1]));
        $this->assertEquals(true, $Validator->isValid([1, 2, 3, 4]));

        // invalid types
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(false));
    }

    public function testMaxIsValid()
    {
        $Validator = new SizeValidator(['max' => 4]);

        // string
        $this->assertEquals(true, $Validator->isValid(''));
        $this->assertEquals(true, $Validator->isValid('t'));
        $this->assertEquals(true, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid('testt'));

        // int
        $this->assertEquals(true, $Validator->isValid(0));
        $this->assertEquals(true, $Validator->isValid(1));
        $this->assertEquals(true, $Validator->isValid(4));
        $this->assertEquals(false, $Validator->isValid(5));

        // array
        $this->assertEquals(true, $Validator->isValid([]));
        $this->assertEquals(true, $Validator->isValid([1]));
        $this->assertEquals(true, $Validator->isValid([1, 2, 3, 4]));
        $this->assertEquals(false, $Validator->isValid([1, 2, 3, 4, 5]));

        // invalid types
        $this->assertEquals(true, $Validator->isValid(null));
        $this->assertEquals(true, $Validator->isValid(false));
    }

    public function testMinAndMaxIsValid()
    {
        $Validator = new SizeValidator(['min' => 1, 'max' => 4]);

        // string
        $this->assertEquals(false, $Validator->isValid(''));
        $this->assertEquals(true, $Validator->isValid('t'));
        $this->assertEquals(true, $Validator->isValid('tes'));
        $this->assertEquals(true, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid('testt'));

        // int
        $this->assertEquals(false, $Validator->isValid(0));
        $this->assertEquals(true, $Validator->isValid(1));
        $this->assertEquals(true, $Validator->isValid(3));
        $this->assertEquals(true, $Validator->isValid(4));
        $this->assertEquals(false, $Validator->isValid(5));

        // array
        $this->assertEquals(false, $Validator->isValid([]));
        $this->assertEquals(true, $Validator->isValid([1]));
        $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        $this->assertEquals(true, $Validator->isValid([1, 2, 3, 4]));
        $this->assertEquals(false, $Validator->isValid([1, 2, 3, 4, 5]));

        // invalid types
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(false));
    }

    public function testSizeAsDefaultIsValid()
    {
        // Test if 'size' is used if 'size' and 'min/max' are specified
        $Validator = new SizeValidator(['size' => 3, 'min' => 1, 'max' => 4]);

        // string
        $this->assertEquals(false, $Validator->isValid(''));
        $this->assertEquals(false, $Validator->isValid('t'));
        $this->assertEquals(true, $Validator->isValid('tes'));
        $this->assertEquals(false, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid('testt'));

        // int
        $this->assertEquals(false, $Validator->isValid(0));
        $this->assertEquals(false, $Validator->isValid(1));
        $this->assertEquals(true, $Validator->isValid(3));
        $this->assertEquals(false, $Validator->isValid(4));
        $this->assertEquals(false, $Validator->isValid(5));

        // array
        $this->assertEquals(false, $Validator->isValid([]));
        $this->assertEquals(false, $Validator->isValid([1]));
        $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        $this->assertEquals(false, $Validator->isValid([1, 2, 3, 4]));
        $this->assertEquals(false, $Validator->isValid([1, 2, 3, 4, 5]));

        // invalid types
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(false));
    }
}