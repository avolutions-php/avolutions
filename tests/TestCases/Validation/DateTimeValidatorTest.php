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
use Avolutions\Validation\DateTimeValidator;
use InvalidArgumentException;

class DateTimeValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        new Application(__DIR__);
    }

    public function testOptionTypeIsValid()
    {
        $validTypes = ['date', 'time', 'datetime'];
        foreach ($validTypes as $validType) {
            $Validator = new DateTimeValidator(['type' => $validType]);
            $this->assertInstanceOf(DateTimeValidator::class, $Validator);
        }

        $this->expectException(InvalidArgumentException::class);
        new DateTimeValidator(['type' => 'test']);
    }

    public function testOptionFormatIsValid()
    {
        $Validator = new DateTimeValidator(['format' => 'Y-m-d']);
        $this->assertInstanceOf(DateTimeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        new DateTimeValidator(['format' => 123]);
    }

    public function testDefaultDateFormat()
    {
        $Validator = new DateTimeValidator(['type' => 'date']);

        $this->assertEquals(true, $Validator->isValid('2021-07-03'));
        $this->assertEquals(false, $Validator->isValid('2021-07-32'));
        $this->assertEquals(false, $Validator->isValid('2021-99-03'));
        $this->assertEquals(false, $Validator->isValid('10000-07-03'));
        $this->assertEquals(false, $Validator->isValid('07.03.2021'));

        $this->assertEquals(false, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(false));
    }

    public function testDefaultTimeFormat()
    {
        $Validator = new DateTimeValidator(['type' => 'time']);

        $this->assertEquals(true, $Validator->isValid('12:34:56'));
        $this->assertEquals(false, $Validator->isValid('12:34:61'));
        $this->assertEquals(false, $Validator->isValid('12:61:56'));
        $this->assertEquals(false, $Validator->isValid('25:34:56'));
        $this->assertEquals(false, $Validator->isValid('12.34.56'));

        $this->assertEquals(false, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(false));
    }

    public function testDefaultDateTimeFormat()
    {
        $Validator = new DateTimeValidator(['type' => 'datetime']);

        $this->assertEquals(true, $Validator->isValid('2021-07-03 12:34:56'));
        $this->assertEquals(false, $Validator->isValid('2021-07-03 12:34:61'));
        $this->assertEquals(false, $Validator->isValid('2021-07-03 12:61:56'));
        $this->assertEquals(false, $Validator->isValid('2021-07-03 25:34:56'));

        $this->assertEquals(true, $Validator->isValid('2021-07-03 12:34:56'));
        $this->assertEquals(false, $Validator->isValid('2021-07-32 12:34:56'));
        $this->assertEquals(false, $Validator->isValid('2021-99-03 12:34:56'));
        $this->assertEquals(false, $Validator->isValid('10000-07-03 12:34:56'));

        $this->assertEquals(false, $Validator->isValid('07.03.2021 12:34:56'));
        $this->assertEquals(false, $Validator->isValid('2021-07-03 12.34.56'));
        $this->assertEquals(false, $Validator->isValid('2021-07-0312:34:56'));

        $this->assertEquals(false, $Validator->isValid('test'));
        $this->assertEquals(false, $Validator->isValid(123));
        $this->assertEquals(false, $Validator->isValid(false));
    }

    public function testCustomFormats()
    {
        $Validator = new DateTimeValidator(['format' => 'd.m.Y']);
        $this->assertEquals(true, $Validator->isValid('07.03.2021'));
        $this->assertEquals(false, $Validator->isValid('32.03.2021'));
        $this->assertEquals(false, $Validator->isValid('07.13.2021'));
        $this->assertEquals(false, $Validator->isValid('07.03.10000'));
        $this->assertEquals(false, $Validator->isValid('2021-07-03'));
    }
}