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

use PHPUnit\Framework\TestCase;

use Avolutions\Command\Option;

class OptionTest extends TestCase
{
    public function testDefaultValues()
    {
        $Option = new Option('name');

        $this->assertEquals('name', $Option->name);
        $this->assertEquals('', $Option->short);
        $this->assertEquals('', $Option->help);
        $this->assertEquals(false, $Option->default);
    }

    public function testOptionValues()
    {
        $Option = new Option('name', 'n', 'help', true);

        $this->assertEquals('name', $Option->name);
        $this->assertEquals('n', $Option->short);
        $this->assertEquals('help', $Option->help);
        $this->assertEquals(true, $Option->default);
    }
}