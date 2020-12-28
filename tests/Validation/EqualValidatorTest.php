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

use Avolutions\Validation\Validator\EqualValidator;

class EqualValidatorTest extends TestCase
{
    public function testStringIsValid() {
        $Validator = new EqualValidator('test');
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid('testtest'), false);
    }

    public function testIntIsValid() {
        $Validator = new EqualValidator(1);
        $this->assertEquals($Validator->isValid(1), true);
        $this->assertEquals($Validator->isValid(2), false);
        $this->assertEquals($Validator->isValid('1'), false);
    }

    public function testBoolIsValid() {
        $Validator = new EqualValidator(true);
        $this->assertEquals($Validator->isValid(true), true);
        $this->assertEquals($Validator->isValid(false), false);
    }

    public function testArrayIsValid() {
        $Validator = new EqualValidator([1,2]);
        $this->assertEquals($Validator->isValid([1,2]), true);
        $this->assertEquals($Validator->isValid([1,2,3]), false);
    }
}