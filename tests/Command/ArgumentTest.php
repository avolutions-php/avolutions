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

use Avolutions\Command\Argument;

class ArgumentTest extends TestCase
{
    public function testDefaultValues()
    {
        $Argument = new Argument('name');

        $this->assertEquals('name', $Argument->name);
        $this->assertEquals('', $Argument->help);
        $this->assertEquals(false, $Argument->optional);
        $this->assertEquals(null, $Argument->default);
    }

    public function testNonOptionalArgumentValues()
    {
        $Argument = new Argument('name', 'help', false, 'default');

        $this->assertEquals('name', $Argument->name);
        $this->assertEquals('help', $Argument->help);
        $this->assertEquals(false, $Argument->optional);
        $this->assertEquals(null, $Argument->default);
    }

    public function testOptionalArgumentValues()
    {
        $Argument = new Argument('name', 'help', true, 'default');

        $this->assertEquals('name', $Argument->name);
        $this->assertEquals('help', $Argument->help);
        $this->assertEquals(true, $Argument->optional);
        $this->assertEquals('default', $Argument->default);
    }
}