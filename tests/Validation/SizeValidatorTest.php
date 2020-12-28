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

use Avolutions\Validation\Validator\SizeValidator;

class SizeValidatorTest extends TestCase
{
    public function testStringIsValid() {
        $Validator = new SizeValidator(4);
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid(''), false);
        $this->assertEquals($Validator->isValid('testtest'), false);
        $this->assertEquals($Validator->isValid(null), false);
        
        $Validator = new SizeValidator([0, 5]);
        $this->assertEquals($Validator->isValid('t'), true);
        $this->assertEquals($Validator->isValid('test'), true);
        $this->assertEquals($Validator->isValid(''), false);
        $this->assertEquals($Validator->isValid('testt'), false);
        $this->assertEquals($Validator->isValid(null), false);

        $Validator = new SizeValidator([4]);
        $this->assertEquals($Validator->isValid('test'), false);

        $Validator = new SizeValidator([0,5,10]);
        $this->assertEquals($Validator->isValid('test'), false);
    }

    public function testIntIsValid() {
        $Validator = new SizeValidator(4);
        $this->assertEquals($Validator->isValid(4), true);
        $this->assertEquals($Validator->isValid(0), false);
        $this->assertEquals($Validator->isValid(5), false);
        $this->assertEquals($Validator->isValid(null), false);
        
        $Validator = new SizeValidator([0, 5]);
        $this->assertEquals($Validator->isValid(1), true);
        $this->assertEquals($Validator->isValid(4), true);
        $this->assertEquals($Validator->isValid(0), false);
        $this->assertEquals($Validator->isValid(6), false);
        $this->assertEquals($Validator->isValid(null), false);

        $Validator = new SizeValidator([4]);
        $this->assertEquals($Validator->isValid(4), false);

        $Validator = new SizeValidator([0,5,10]);
        $this->assertEquals($Validator->isValid(4), false);
    }

    public function testArrayIsValid() {
        $Validator = new SizeValidator(4);
        $this->assertEquals($Validator->isValid([1,2,3,4]), true);
        $this->assertEquals($Validator->isValid([1,2,3]), false);
        $this->assertEquals($Validator->isValid([1,2,3,4,5]), false);
        $this->assertEquals($Validator->isValid([]), false);
        $this->assertEquals($Validator->isValid(null), false);
        
        $Validator = new SizeValidator([0, 5]);
        $this->assertEquals($Validator->isValid([1]), true);
        $this->assertEquals($Validator->isValid([1,2,3,4]), true);
        $this->assertEquals($Validator->isValid([]), false);
        $this->assertEquals($Validator->isValid([1,2,3,4,5]), false);
        $this->assertEquals($Validator->isValid(null), false);

        $Validator = new SizeValidator([4]);
        $this->assertEquals($Validator->isValid([1,2,3,4]), false);

        $Validator = new SizeValidator([0,5,10]);
        $this->assertEquals($Validator->isValid([1,2,3,4]), false);
    }
}