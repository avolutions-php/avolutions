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

use Avolutions\Orm\Entity;
use Avolutions\Validation\Validator\RangeValidator;

class RangeValidatorTest extends TestCase
{
    private $range;
    private $Entity;

    protected function setUp(): void
    {
        $this->range = [1, 'test', '4', false, null, [2, 3]];

        $this->Entity = new Entity();
        $this->Entity->range = $this->range;
    }

    public function testMandatoryOptionsAreSet() {
        $Validator = new RangeValidator(['range' => $this->range]);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $Validator = new RangeValidator(['attribute' => 'range'], null, $this->Entity);
        $this->assertInstanceOf(RangeValidator::class, $Validator);
        
        $this->expectException(InvalidArgumentException::class);
        $Validator = new RangeValidator();
    }

    public function testOptionsValidFormat() {        
        $this->expectException(InvalidArgumentException::class);
        $Validator = new RangeValidator(['range' => 'test']);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new RangeValidator(['attribute' => 'test'], null, $this->Entity);
        
        $this->expectException(InvalidArgumentException::class);
        $Validator = new RangeValidator(['range' => [],'not' => 'test']);

        $Validator = new RangeValidator(['range' => [], 'not' => true]);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new RangeValidator(['range' => [], 'strict' => 'test']);

        $Validator = new RangeValidator(['range' => [], 'strict' => true]);
        $this->assertInstanceOf(RangeValidator::class, $Validator);
    }

    public function testRangeIsValid() {        
        $Validators[] = new RangeValidator(['range' => $this->range]);
        $Validators[] = new RangeValidator(['attribute' => 'range'], null, $this->Entity);

        foreach($Validators as $Validator) {
            // string
            $this->assertEquals($Validator->isValid(''), false); // TODO why is this true?
            $this->assertEquals($Validator->isValid('test'), true);
            $this->assertEquals($Validator->isValid('1'), true);
            $this->assertEquals($Validator->isValid('false'), true);

            // int
            $this->assertEquals($Validator->isValid(0), false);
            $this->assertEquals($Validator->isValid(1), true);
            $this->assertEquals($Validator->isValid(2), true);
            $this->assertEquals($Validator->isValid(4), true);

            // bool
            $this->assertEquals($Validator->isValid(true), false);
            $this->assertEquals($Validator->isValid(false), true);

            // array
            $this->assertEquals($Validator->isValid([2,3]), true);
            $this->assertEquals($Validator->isValid([4,5]), false);

            // other        
            $this->assertEquals($Validator->isValid(null), true);
        }
    }

    public function testRangeIsNotValid() {
        $Validators[] = new RangeValidator(['range' => $this->range, 'not' => true]);
        $Validators[] = new RangeValidator(['attribute' => 'range', 'not' => true], null, $this->Entity);

        foreach($Validators as $Validator) {
            // string
            $this->assertEquals($Validator->isValid(''), true); // TODO why is this false?
            $this->assertEquals($Validator->isValid('test'), false);
            $this->assertEquals($Validator->isValid('1'), false);
            $this->assertEquals($Validator->isValid('false'), false);

            // int
            $this->assertEquals($Validator->isValid(0), true);
            $this->assertEquals($Validator->isValid(1), false);
            $this->assertEquals($Validator->isValid(2), false);
            $this->assertEquals($Validator->isValid(4), false);

            // bool
            $this->assertEquals($Validator->isValid(true), true);
            $this->assertEquals($Validator->isValid(false), false);

            // array
            $this->assertEquals($Validator->isValid([2,3]), false);
            $this->assertEquals($Validator->isValid([4,5]), true);

            // other        
            $this->assertEquals($Validator->isValid(null), false);
        }
    }

    public function testRangeStrictIsValid() {
        $Validators[] = new RangeValidator(['range' => $this->range, 'strict' => true]);
        $Validators[] = new RangeValidator(['attribute' => 'range', 'strict' => true], null, $this->Entity);

        foreach($Validators as $Validator) {
            // string
            $this->assertEquals($Validator->isValid(''), false); // TODO why is this true?
            $this->assertEquals($Validator->isValid('test'), true);
            $this->assertEquals($Validator->isValid('1'), false);
            $this->assertEquals($Validator->isValid('false'), false);

            // int
            $this->assertEquals($Validator->isValid(0), false);
            $this->assertEquals($Validator->isValid(1), true);
            $this->assertEquals($Validator->isValid(2), true);
            $this->assertEquals($Validator->isValid(4), false);

            // bool
            $this->assertEquals($Validator->isValid(true), false);
            $this->assertEquals($Validator->isValid(false), true);

            // array
            $this->assertEquals($Validator->isValid([2,3]), true);
            $this->assertEquals($Validator->isValid([4,5]), false);

            // other        
            $this->assertEquals($Validator->isValid(null), true);
        }
    }
}