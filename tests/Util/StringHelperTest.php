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

use Avolutions\Util\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function testInterpolate()
    {
        $stringWithNumericPlaceholders = 'Hey, my name is {0}. I\'m {1} years old.';
        $stringWithNamedPlaceholders = 'Hey, my name is {name}. I\'m {age} years old.';

        $this->assertEquals('Hey, my name is Alex. I\'m 42 years old.', StringHelper::interpolate($stringWithNumericPlaceholders, ['Alex', 42]));
        $this->assertEquals('Hey, my name is Alex. I\'m 42 years old.', StringHelper::interpolate($stringWithNamedPlaceholders, ['age' => 42, 'name' => 'Alex']));
    }
}