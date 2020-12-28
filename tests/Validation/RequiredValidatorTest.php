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

use Avolutions\Validation\Validator\RequiredValidator;

class RequiredValidatorTest extends TestCase
{
    public function testStringIsValid() {
        $Validator = new RequiredValidator();
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid(''), false);
    }

    public function testIntIsValid() {
        $Validator = new RequiredValidator();
        $this->assertEquals($Validator->isValid(1), true);
        $this->assertEquals($Validator->isValid(0), true);
        $this->assertEquals($Validator->isValid(null), false);
    }

    public function testArrayIsValid() {
        $Validator = new RequiredValidator();
        $this->assertEquals($Validator->isValid([1,2,3]), true);
        $this->assertEquals($Validator->isValid([]), false);
    }
}