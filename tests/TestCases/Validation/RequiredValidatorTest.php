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

use PHPUnit\Framework\TestCase;

use Avolutions\Validation\RequiredValidator;

class RequiredValidatorTest extends TestCase
{
    public function testStringIsValid()
    {
        $Validator = new RequiredValidator();

        $this->assertEquals(true, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid(''));
    }

    public function testIntIsValid()
    {
        $Validator = new RequiredValidator();

        $this->assertEquals(true, $Validator->isValid(1));
        $this->assertEquals(true, $Validator->isValid(0));
    }

    public function testArrayIsValid()
    {
        $Validator = new RequiredValidator();

        $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        $this->assertEquals(false, $Validator->isValid([]));
    }

    public function testBoolIsValid()
    {
        $Validator = new RequiredValidator();

        $this->assertEquals(true, $Validator->isValid(true));
        $this->assertEquals(true, $Validator->isValid(false));
    }

    public function testNullIsNotValid()
    {
        $Validator = new RequiredValidator();

        $this->assertEquals(false, $Validator->isValid(null));
    }
}