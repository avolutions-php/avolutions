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

use Avolutions\Core\Application;
use Avolutions\Orm\Entity;
use Avolutions\Validation\RangeValidator;
use InvalidArgumentException;

class RangeValidatorTest extends TestCase
{
    private array $range;
    private Entity $Entity;

    protected function setUp(): void
    {
        new Application(__DIR__);

        $this->Entity = new class extends Entity {
            public array $range = [];
        };

        $this->range = [1, 'test', '4', false, null, [2, 3]];
        $this->Entity->range = $this->range;
    }

    public function testMandatoryOptionsAreSet()
    {
        $Validator = new RangeValidator(['range' => $this->range]);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $Validator = new RangeValidator(['attribute' => 'range'], null, $this->Entity);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RangeValidator();
    }

    public function testOptionRangeValidFormat()
    {
        $Validator = new RangeValidator(['range' => []]);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RangeValidator(['range' => 'test']);
    }

    public function testOptionAttributeValidFormat()
    {
        $Validator = new RangeValidator(['attribute' => 'range'], null, $this->Entity);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RangeValidator(['attribute' => 'test'], null, $this->Entity);
    }

    public function testOptionNotValidFormat()
    {
        $Validator = new RangeValidator(['range' => [], 'not' => true]);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RangeValidator(['range' => [], 'not' => 'test']);
    }

    public function testOptionStrictValidFormat()
    {
        $Validator = new RangeValidator(['range' => [], 'strict' => true]);
        $this->assertInstanceOf(RangeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new RangeValidator(['range' => [], 'strict' => 'test']);
    }

    public function testRangeIsValid()
    {
        $Validators[] = new RangeValidator(['range' => $this->range]);
        $Validators[] = new RangeValidator(['attribute' => 'range'], null, $this->Entity);

        foreach ($Validators as $Validator) {
            // string
            $this->assertEquals(true, $Validator->isValid('')); // because of null
            $this->assertEquals(true, $Validator->isValid('test'));
            $this->assertEquals(true, $Validator->isValid('1'));
            $this->assertEquals(false, $Validator->isValid('false'));

            // int
            $this->assertEquals(true, $Validator->isValid(0));
            $this->assertEquals(true, $Validator->isValid(1));
            $this->assertEquals(false, $Validator->isValid(2));
            $this->assertEquals(true, $Validator->isValid(4));

            // bool
            $this->assertEquals(true, $Validator->isValid(true)); // because of 1
            $this->assertEquals(true, $Validator->isValid(false));

            // array
            $this->assertEquals(true, $Validator->isValid([2, 3]));
            $this->assertEquals(false, $Validator->isValid([4, 5]));

            // other
            $this->assertEquals(true, $Validator->isValid(null));
        }
    }

    public function testRangeIsNotValid()
    {
        $Validators[] = new RangeValidator(['range' => $this->range, 'not' => true]);
        $Validators[] = new RangeValidator(['attribute' => 'range', 'not' => true], null, $this->Entity);

        foreach ($Validators as $Validator) {
            // string
            $this->assertEquals(false, $Validator->isValid('')); // because of null
            $this->assertEquals(false, $Validator->isValid('test'));
            $this->assertEquals(false, $Validator->isValid('1'));
            $this->assertEquals(true, $Validator->isValid('false'));

            // int
            $this->assertEquals(false, $Validator->isValid(0));
            $this->assertEquals(false, $Validator->isValid(1));
            $this->assertEquals(true, $Validator->isValid(2));
            $this->assertEquals(false, $Validator->isValid(4));

            // bool
            $this->assertEquals(false, $Validator->isValid(true)); // because of 1
            $this->assertEquals(false, $Validator->isValid(false));

            // array
            $this->assertEquals(false, $Validator->isValid([2, 3]));
            $this->assertEquals(true, $Validator->isValid([4, 5]));

            // other
            $this->assertEquals(false, $Validator->isValid(null));
        }
    }

    public function testRangeStrictIsValid()
    {
        $Validators[] = new RangeValidator(['range' => $this->range, 'strict' => true]);
        $Validators[] = new RangeValidator(['attribute' => 'range', 'strict' => true], null, $this->Entity);

        foreach ($Validators as $Validator) {
            // string
            $this->assertEquals(false, $Validator->isValid('')); // because of null
            $this->assertEquals(true, $Validator->isValid('test'));
            $this->assertEquals(false, $Validator->isValid('1'));
            $this->assertEquals(false, $Validator->isValid('false'));

            // int
            $this->assertEquals(false, $Validator->isValid(0));
            $this->assertEquals(true, $Validator->isValid(1));
            $this->assertEquals(false, $Validator->isValid(2));
            $this->assertEquals(false, $Validator->isValid(4));

            // bool
            $this->assertEquals(false, $Validator->isValid(true)); // because of 1
            $this->assertEquals(true, $Validator->isValid(false));

            // array
            $this->assertEquals(true, $Validator->isValid([2, 3]));
            $this->assertEquals(false, $Validator->isValid([4, 5]));

            // other
            $this->assertEquals(true, $Validator->isValid(null));
        }
    }
}