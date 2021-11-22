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

namespace Avolutions\Test\Validation;

use PHPUnit\Framework\TestCase;

use Avolutions\Core\Application;
use Avolutions\Orm\Entity;
use Avolutions\Validation\CompareValidator;
use InvalidArgumentException;

class CompareValidatorTest extends TestCase
{
    private Entity $Entity;

    protected function setUp(): void
    {
        new Application(__DIR__);
        $this->Entity = new class extends Entity {
            public string $testString = '123';
            public int $testInt = 123;
        };
    }

    public function testMandatoryOptionOperatorIsSet()
    {
        $Validator = new CompareValidator(['operator' => '==', 'value' => 'test']);
        $this->assertInstanceOf(CompareValidator::class, $Validator);

        $Validator = new CompareValidator(['operator' => '==', 'attribute' => 'testString'], null, $this->Entity);
        $this->assertInstanceOf(CompareValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new CompareValidator(['operator' => '==']);
    }

    public function testOptionOperatorValidFormat()
    {
        $validOperators = ['==', '===', '!=', '!==', '>', '>=', '<', '<='];
        foreach ($validOperators as $validOperator) {
            $Validator = new CompareValidator(['operator' => $validOperator, 'value' => 'test']);
            $this->assertInstanceOf(CompareValidator::class, $Validator);
        }

        $this->expectException(InvalidArgumentException::class);
        new CompareValidator(['operator' => 'test']);
    }

    public function testIsEqual()
    {
        $Validators[] = new CompareValidator(['operator' => '==', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '==', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(true, $Validator->isValid('123'));
            $this->assertEquals(false, $Validator->isValid('test'));
            $this->assertEquals(true, $Validator->isValid(123));
            $this->assertEquals(true, $Validator->isValid(true));
            $this->assertEquals(false, $Validator->isValid([1, 2, 3]));
        }
    }

    public function testIsIdentical()
    {
        $Validators[] = new CompareValidator(['operator' => '===', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '===', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(true, $Validator->isValid('123'));
            $this->assertEquals(false, $Validator->isValid('test'));
            $this->assertEquals(false, $Validator->isValid(123));
            $this->assertEquals(false, $Validator->isValid(true));
            $this->assertEquals(false, $Validator->isValid([1, 2, 3]));
        }
    }

    public function testIsNotEqual()
    {
        $Validators[] = new CompareValidator(['operator' => '!=', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '!=', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(false, $Validator->isValid('123'));
            $this->assertEquals(true, $Validator->isValid('test'));
            $this->assertEquals(false, $Validator->isValid(123));
            $this->assertEquals(false, $Validator->isValid(true));
            $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        }
    }

    public function testIsNotIdentical()
    {
        $Validators[] = new CompareValidator(['operator' => '!==', 'value' => '123']);
        $Validators[] = new CompareValidator(['operator' => '!==', 'attribute' => 'testString'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(false, $Validator->isValid('123'));
            $this->assertEquals(true, $Validator->isValid('test'));
            $this->assertEquals(true, $Validator->isValid(123));
            $this->assertEquals(true, $Validator->isValid(true));
            $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        }
    }

    public function testIsGreaterThan()
    {
        $Validators[] = new CompareValidator(['operator' => '>', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '>', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(false, $Validator->isValid('123'));
            $this->assertEquals(true, $Validator->isValid('test'));
            $this->assertEquals(false, $Validator->isValid(122));
            $this->assertEquals(false, $Validator->isValid(123));
            $this->assertEquals(true, $Validator->isValid(124));
            $this->assertEquals(false, $Validator->isValid(true));
            $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        }
    }

    public function testIsGreaterOrEqualThan()
    {
        $Validators[] = new CompareValidator(['operator' => '>=', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '>=', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(true, $Validator->isValid('123'));
            $this->assertEquals(true, $Validator->isValid('test'));
            $this->assertEquals(false, $Validator->isValid(122));
            $this->assertEquals(true, $Validator->isValid(123));
            $this->assertEquals(true, $Validator->isValid(124));
            $this->assertEquals(true, $Validator->isValid(true));
            $this->assertEquals(true, $Validator->isValid([1, 2, 3]));
        }
    }

    public function testIsLessThan()
    {
        $Validators[] = new CompareValidator(['operator' => '<', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '<', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(false, $Validator->isValid('123'));
            $this->assertEquals(false, $Validator->isValid('test'));
            $this->assertEquals(true, $Validator->isValid(122));
            $this->assertEquals(false, $Validator->isValid(123));
            $this->assertEquals(false, $Validator->isValid(124));
            $this->assertEquals(false, $Validator->isValid(true));
            $this->assertEquals(false, $Validator->isValid([1, 2, 3]));
        }
    }

    public function testIsLessOrEqualThan()
    {
        $Validators[] = new CompareValidator(['operator' => '<=', 'value' => 123]);
        $Validators[] = new CompareValidator(['operator' => '<=', 'attribute' => 'testInt'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            $this->assertEquals(true, $Validator->isValid('123'));
            $this->assertEquals(false, $Validator->isValid('test'));
            $this->assertEquals(true, $Validator->isValid(122));
            $this->assertEquals(true, $Validator->isValid(123));
            $this->assertEquals(false, $Validator->isValid(124));
            $this->assertEquals(true, $Validator->isValid(true));
            $this->assertEquals(false, $Validator->isValid([1, 2, 3]));
        }
    }
}