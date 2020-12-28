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

use Avolutions\Validation\Validator\TypeValidator;

class TypeValidatorTest extends TestCase
{
    public function testStringIsValid() {
        $Validator = new TypeValidator('string');
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid(''), true);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
    }

    public function testIntIsValid() {
        $Validator = new TypeValidator('int');
        $this->assertEquals($Validator->isValid(123), true);
        $this->assertEquals($Validator->isValid(0), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
    }

    public function testBoolIsValid() {
        $Validator = new TypeValidator('bool');
        $this->assertEquals($Validator->isValid(true), true);
        $this->assertEquals($Validator->isValid(false), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(['1','2','3']), false);
        $this->assertEquals($Validator->isValid(null), false);
    }

    public function testArrayIsValid() {
        $Validator = new TypeValidator('array');
        $this->assertEquals($Validator->isValid([1,2,3]), true);
        $this->assertEquals($Validator->isValid(['1','2','3']), true);
        $this->assertEquals($Validator->isValid([]), true);
        $this->assertEquals($Validator->isValid('123'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(true), false);
        $this->assertEquals($Validator->isValid(null), false);
    }
}