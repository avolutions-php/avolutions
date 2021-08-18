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

use Avolutions\Command\AbstractCommand;
use Avolutions\Command\Argument;
use Avolutions\Command\ExitStatus;
use Avolutions\Command\Option;


class CommandTest extends TestCase
{
    public function testCommandNameAndDescription()
    {
        $Command = new class extends AbstractCommand {
            protected static string $name = 'test-command';
            protected static string $description = 'Test description.';

            public function execute(): int {}
            public function initialize(): void {}
        };

        $this->assertEquals('test-command', $Command->getName());
        $this->assertEquals('Test description.', $Command->getDescription());
    }

    public function testCommandArgumentAndOptionDefinition()
    {
        $Command = new class extends AbstractCommand {
            protected static string $name = 'test-command';
            protected static string $description = 'Test description.';

            public function execute(): int {}
            public function initialize(): void
            {
                $this->addArgumentDefinition(new Argument('foo', 'Foo argument.'));
                $this->addOptionDefinition(new Option('bar', 'b', 'Bar option.'));
            }
        };

        $this->assertEquals(new Argument('foo', 'Foo argument.'), $Command->CommandDefinition->getArguments()[0]);
        $this->assertEquals(new Option('bar', 'b', 'Bar option.'), $Command->CommandDefinition->getOptions()[0]);
    }

    public function testCommandStart()
    {
        $Command = new class extends AbstractCommand {
            public function execute(): int {
                if ($this->getArgument('foo') == 'foo') {
                    return ExitStatus::SUCCESS;
                }

                if ($this->getOption('bar')) {
                    return ExitStatus::SUCCESS;
                }

                return ExitStatus::ERROR;
            }

            public function initialize(): void
            {
                $this->addArgumentDefinition(new Argument('foo', 'Foo argument.'));
                $this->addOptionDefinition(new Option('bar', 'b', 'Bar option.'));
            }
        };

        $this->assertEquals(ExitStatus::SUCCESS, $Command->start(['foo']));
        $this->assertEquals(ExitStatus::ERROR, $Command->start(['test']));
        $this->assertEquals(ExitStatus::SUCCESS, $Command->start(['test', '--bar']));
        $this->assertEquals(ExitStatus::SUCCESS, $Command->start(['test', '-b']));
        $this->assertEquals(ExitStatus::ERROR, $Command->start(['test', '--test']));
    }

    public function testRequiredArgument()
    {
        $Command = new class extends AbstractCommand {
            public function execute(): int {}

            public function initialize(): void
            {
                $this->addArgumentDefinition(new Argument('foo', 'Foo argument.'));
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $Command->start([]);
    }
}