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

use Avolutions\Validation\TypeValidator;

class TypeValidatorTest extends TestCase
{
    public function testMandatoryOptionsAreSet() {
        $this->expectException(InvalidArgumentException::class);
        $Validator = new TypeValidator();
    }

    public function testOptionsValidFormat() {
        $validTypes = ['int', 'integer', 'string', 'bool', 'boolean', 'array', 'datetime'];
        foreach ($validTypes as $validType) {
            $Validator = new TypeValidator(['type' => $validType]);
            $this->assertInstanceOf(TypeValidator::class, $Validator);
        }

        $this->expectException(InvalidArgumentException::class);
        $Validator = new TypeValidator(['type' => 'test']);
    }

    public function testStringIsValid() {
        $Validator = new TypeValidator(['type' => 'string']);

        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid(''), true);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(new DateTime()), false);
    }

    public function testIntIsValid() {
        $Validator = new TypeValidator(['type' => 'int']);

        $this->assertEquals($Validator->isValid(123), true);
        $this->assertEquals($Validator->isValid(0), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(new DateTime()), false);
    }

    public function testIntegerIsValid() {
        $Validator = new TypeValidator(['type' => 'integer']);

        $this->assertEquals($Validator->isValid(123), true);
        $this->assertEquals($Validator->isValid(0), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(new DateTime()), false);
    }

    public function testBoolIsValid() {
        $Validator = new TypeValidator(['type' => 'bool']);

        $this->assertEquals($Validator->isValid(true), true);
        $this->assertEquals($Validator->isValid(false), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(new DateTime()), false);
    }

    public function testBooleanIsValid() {
        $Validator = new TypeValidator(['type' => 'boolean']);

        $this->assertEquals($Validator->isValid(true), true);
        $this->assertEquals($Validator->isValid(false), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(new DateTime()), false);
    }

    public function testArrayIsValid() {
        $Validator = new TypeValidator(['type' => 'array']);

        $this->assertEquals($Validator->isValid([1,2,3]), true);
        $this->assertEquals($Validator->isValid(['1','2','3']), true);
        $this->assertEquals($Validator->isValid([]), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(null), false);
        $this->assertEquals($Validator->isValid(new DateTime()), false);
    }

    public function testDateTimesValid() {
        $Validator = new TypeValidator(['type' => 'datetime']);

        $this->assertEquals($Validator->isValid(new DateTime()), true);
        $this->assertEquals($Validator->isValid('test'), false);
        $this->assertEquals($Validator->isValid(''), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
    }
}