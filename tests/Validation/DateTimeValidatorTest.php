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

use Avolutions\Validation\DateTimeValidator;
use PHPUnit\Framework\TestCase;

class DateTimeValidatorTest extends TestCase
{
    public function testOptionTypeIsValid()
    {
        $validTypes = ['date', 'time', 'datetime'];
        foreach ($validTypes as $validType) {
            $Validator = new DateTimeValidator(['type' => $validType]);
            $this->assertInstanceOf(DateTimeValidator::class, $Validator);
        }

        $this->expectException(InvalidArgumentException::class);
        $Validator = new DateTimeValidator(['type' => 'test']);
    }

    public function testOptionFormatIsValid() {
        $Validator = new DateTimeValidator(['format' => 'Y-m-d']);
        $this->assertInstanceOf(DateTimeValidator::class, $Validator);

        $this->expectException(InvalidArgumentException::class);
        $Validator = new DateTimeValidator(['format' => 123]);
    }

    public function testDefaultDateFormat()
    {
        $Validator = new DateTimeValidator(['type' => 'date']);

        $this->assertEquals($Validator->isValid('2021-07-03'), true);
        $this->assertEquals($Validator->isValid('2021-07-32'), false);
        $this->assertEquals($Validator->isValid('2021-99-03'), false);
        $this->assertEquals($Validator->isValid('10000-07-03'), false);
        $this->assertEquals($Validator->isValid('07.03.2021'), false);

        $this->assertEquals($Validator->isValid('test'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(false), false);
    }

    public function testDefaultTimeFormat()
    {
        $Validator = new DateTimeValidator(['type' => 'time']);

        $this->assertEquals($Validator->isValid('12:34:56'), true);
        $this->assertEquals($Validator->isValid('12:34:61'), false);
        $this->assertEquals($Validator->isValid('12:61:56'), false);
        $this->assertEquals($Validator->isValid('25:34:56'), false);
        $this->assertEquals($Validator->isValid('12.34.56'), false);

        $this->assertEquals($Validator->isValid('test'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(false), false);
    }

    public function testDefaultDateTimeFormat()
    {
        $Validator = new DateTimeValidator(['type' => 'datetime']);

        $this->assertEquals($Validator->isValid('2021-07-03 12:34:56'), true);
        $this->assertEquals($Validator->isValid('2021-07-03 12:34:61'), false);
        $this->assertEquals($Validator->isValid('2021-07-03 12:61:56'), false);
        $this->assertEquals($Validator->isValid('2021-07-03 25:34:56'), false);

        $this->assertEquals($Validator->isValid('2021-07-03 12:34:56'), true);
        $this->assertEquals($Validator->isValid('2021-07-32 12:34:56'), false);
        $this->assertEquals($Validator->isValid('2021-99-03 12:34:56'), false);
        $this->assertEquals($Validator->isValid('10000-07-03 12:34:56'), false);

        $this->assertEquals($Validator->isValid('07.03.2021 12:34:56'), false);
        $this->assertEquals($Validator->isValid('2021-07-03 12.34.56'), false);
        $this->assertEquals($Validator->isValid('2021-07-0312:34:56'), false);

        $this->assertEquals($Validator->isValid('test'), false);
        $this->assertEquals($Validator->isValid(123), false);
        $this->assertEquals($Validator->isValid(false), false);
    }

    public function testCustomFormats()
    {
        $Validator = new DateTimeValidator(['format' => 'd.m.Y']);
        $this->assertEquals($Validator->isValid('07.03.2021'), true);
        $this->assertEquals($Validator->isValid('32.03.2021'), false);
        $this->assertEquals($Validator->isValid('07.13.2021'), false);
        $this->assertEquals($Validator->isValid('07.03.10000'), false);
        $this->assertEquals($Validator->isValid('2021-07-03'), false);
    }
}