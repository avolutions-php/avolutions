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
use Avolutions\Command\CommandDefinition;
use Avolutions\Command\Option;

class CommandDefinitionTest extends TestCase
{
    public function testArgumentSetAndGet()
    {
        $Argument = new Argument('name', 'help');

        $CommandDefinition = new CommandDefinition();
        $CommandDefinition->addArgument($Argument);

        $this->assertEquals([$Argument], $CommandDefinition->getArguments());
    }

    public function testOptionSetAndGet()
    {
        $Option = new Option('name', 'n', 'help');

        $CommandDefinition = new CommandDefinition();
        $CommandDefinition->addOption($Option);

        $this->assertEquals([$Option], $CommandDefinition->getOptions());
    }
}