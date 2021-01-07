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

use Avolutions\Orm\Entity;
use Avolutions\Validation\Validator\CompareValidator;

class CompareValidatorTest extends TestCase
{
    private $Entity;

    protected function setUp(): void
    {
        $this->Entity = new Entity();
        $this->Entity->testString = '123';
        $this->Entity->testInt = 123;
    }

    public function testMandatoryOptionOperatorIsSet() {
        $Validator = new CompareValidator(['operator' => '==', 'value' => 'test']);
        $this->assertInstanceOf(CompareValidator::class, $Validator);

        $Validator = new CompareValidator(['operator' => '==', 'attribute' => 'testString'], null, $this->Entity);
        $this->assertInstanceOf(CompareValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new CompareValidator(['operator' => '==']);
    }

    public function testOptionOperatorValidFormat() {
        $validOperators = ['==', '===', '!=', '!==', '>', '>=', '<', '<='];
        foreach ($validOperators as $validOperator) {
            $Validator = new CompareValidator(['operator' => $validOperator, 'value' => 'test']);
            $this->assertInstanceOf(CompareValidator::class, $Validator);
        }

        $this->expectException(InvalidArgumentException::class);
        $Validator = new CompareValidator(['operator' => 'test']);
    }

    public function testIsEqual() {
        $Validators[] = new CompareValidator(['operator' => '==', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '==', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), true);
            $this->assertEquals($Validator->isValid('test'), false);
            $this->assertEquals($Validator->isValid(123), true);
            $this->assertEquals($Validator->isValid(true), true);
            $this->assertEquals($Validator->isValid([1,2,3]), false);
        }
    }

    public function testIsIdentical() {
        $Validators[] = new CompareValidator(['operator' => '===', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '===', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), true);
            $this->assertEquals($Validator->isValid('test'), false);
            $this->assertEquals($Validator->isValid(123), false);
            $this->assertEquals($Validator->isValid(true), false);
            $this->assertEquals($Validator->isValid([1,2,3]), false);
        }
    }

    public function testIsNotEqual() {
        $Validators[] = new CompareValidator(['operator' => '!=', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '!=', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), false);
            $this->assertEquals($Validator->isValid('test'), true);
            $this->assertEquals($Validator->isValid(123), false);
            $this->assertEquals($Validator->isValid(true), false);
            $this->assertEquals($Validator->isValid([1,2,3]), true);
        }
    }

    public function testIsNotIdentical() {
        $Validators[] = new CompareValidator(['operator' => '!==', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '!==', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), false);
            $this->assertEquals($Validator->isValid('test'), true);
            $this->assertEquals($Validator->isValid(123), true);
            $this->assertEquals($Validator->isValid(true), true);
            $this->assertEquals($Validator->isValid([1,2,3]), true);
        }
    }

    public function testIsGreaterThan() {
        $Validators[] = new CompareValidator(['operator' => '>', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '>', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), false);
            $this->assertEquals($Validator->isValid('test'), false);
            $this->assertEquals($Validator->isValid(122), false);
            $this->assertEquals($Validator->isValid(123), false);
            $this->assertEquals($Validator->isValid(124), true);
            $this->assertEquals($Validator->isValid(true), false);
            $this->assertEquals($Validator->isValid([1,2,3]), true);
        }
    }

    public function testIsGreaterOrEqualThan() {
        $Validators[] = new CompareValidator(['operator' => '>=', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '>=', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), true);
            $this->assertEquals($Validator->isValid('test'), false);
            $this->assertEquals($Validator->isValid(122), false);
            $this->assertEquals($Validator->isValid(123), true);
            $this->assertEquals($Validator->isValid(124), true);
            $this->assertEquals($Validator->isValid(true), true);
            $this->assertEquals($Validator->isValid([1,2,3]), true);
        }
    }

    public function testIsLessThan() {
        $Validators[] = new CompareValidator(['operator' => '<', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '<', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), false);
            $this->assertEquals($Validator->isValid('test'), true);
            $this->assertEquals($Validator->isValid(122), true);
            $this->assertEquals($Validator->isValid(123), false);
            $this->assertEquals($Validator->isValid(124), false);
            $this->assertEquals($Validator->isValid(true), false);
            $this->assertEquals($Validator->isValid([1,2,3]), false);
        }
    }

    public function testIsLessOrEqualThan() {
        $Validators[] = new CompareValidator(['operator' => '<=', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '<=', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals($Validator->isValid('123'), true);
            $this->assertEquals($Validator->isValid('test'), true);
            $this->assertEquals($Validator->isValid(122), true);
            $this->assertEquals($Validator->isValid(123), true);
            $this->assertEquals($Validator->isValid(124), false);
            $this->assertEquals($Validator->isValid(true), true);
            $this->assertEquals($Validator->isValid([1,2,3]), false);
        }
    }
}