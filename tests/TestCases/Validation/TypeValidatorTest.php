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

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use Avolutions\Validation\TypeValidator;

class TypeValidatorTest extends TestCase
{
    public function testMandatoryOptionsAreSet()
    {
        $this->expectException(InvalidArgumentException::class);
        new TypeValidator();
    }

    public function testOptionsValidFormat()
    {
        $validTypes = ['int', 'integer', 'string', 'bool', 'boolean', 'array', 'datetime'];
        foreach ($validTypes as $validType) {
            $Validator = new TypeValidator(['type' => $validType]);
            $this->assertInstanceOf(TypeValidator::class, $Validator);
        }

        $this->expectException(InvalidArgumentException::class);
        new TypeValidator(['type' => 'test']);
    }

    public function testStringIsValid()
    {
        $Validator = new TypeValidator(['type' => 'string']);

        $this->assertEquals(true, $Validator->isValid('test'));
        $this->assertEquals(true, $Validator->isValid(''));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(true));
        $this->assertEquals(false, $Validator->isValid(['1', '2', '3']));
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(new DateTime()));
    }

    public function testIntIsValid()
    {
        $Validator = new TypeValidator(['type' => 'int']);

        $this->assertEquals(true, $Validator->isValid(123));
        $this->assertEquals(true, $Validator->isValid(0));
        $this->assertEquals(false, $Validator->isValid('123'));
        $this->assertEquals(false, $Validator->isValid(true));
        $this->assertEquals(false, $Validator->isValid(['1', '2', '3']));
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(new DateTime()));
    }

    public function testIntegerIsValid()
    {
        $Validator = new TypeValidator(['type' => 'integer']);

        $this->assertEquals(true, $Validator->isValid(123));
        $this->assertEquals(true, $Validator->isValid(0));
        $this->assertEquals(false, $Validator->isValid('123'));
        $this->assertEquals(false, $Validator->isValid(true));
        $this->assertEquals(false, $Validator->isValid(['1', '2', '3']));
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(new DateTime()));
    }

    public function testBoolIsValid()
    {
        $Validator = new TypeValidator(['type' => 'bool']);

        $this->assertEquals(true, $Validator->isValid(true));
        $this->assertEquals(true, $Validator->isValid(false));
        $this->assertEquals(false, $Validator->isValid('123'));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(['1', '2', '3']));
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(new DateTime()));
    }

    public function testBooleanIsValid()
    {
        $Validator = new TypeValidator(['type' => 'boolean']);

        $this->assertEquals(true, $Validator->isValid(true));
        $this->assertEquals(true, $Validator->isValid(false));
        $this->assertEquals(false, $Validator->isValid('123'));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(['1', '2', '3']));
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(new DateTime()));
    }

    public function testArrayIsValid()
    {
        $Validator = new TypeValidator(['type' => 'array']);

        $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        $this->assertEquals(true, $Validator->isValid(['1', '2', '3']));
        $this->assertEquals(true, $Validator->isValid([]));
        $this->assertEquals(false, $Validator->isValid('123'));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(true));
        $this->assertEquals(false, $Validator->isValid(null));
        $this->assertEquals(false, $Validator->isValid(new DateTime()));
    }

    public function testDateTimesValid()
    {
        $Validator = new TypeValidator(['type' => 'datetime']);

        $this->assertEquals(true, $Validator->isValid(new DateTime()));
        $this->assertEquals(false, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid(''));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(true));
        $this->assertEquals(false, $Validator->isValid(['1', '2', '3']));
        $this->assertEquals(false, $Validator->isValid(null));
    }
}