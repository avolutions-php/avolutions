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

namespace Avolutions\Test\Command;

use PHPUnit\Framework\TestCase;

use Avolutions\Core\Application;
use Avolutions\Command\AbstractCommand;
use Avolutions\Command\Argument;
use Avolutions\Command\ExitStatus;
use Avolutions\Command\Option;
use InvalidArgumentException;

class CommandTest extends TestCase
{
    private AbstractCommand $Command;

    public function setUp(): void
    {
        $Application = new Application(__DIR__);
        $this->Command = new class($Application) extends AbstractCommand {
            protected static string $name = 'test-command';
            protected static string $description = 'Test description.';

            public function execute(): int
            {
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
    }

    public function testCommandNameAndDescription()
    {
        $this->assertEquals('test-command', $this->Command->getName());
        $this->assertEquals('Test description.', $this->Command->getDescription());
    }

    public function testCommandArgumentAndOptionDefinition()
    {
        $this->assertEquals(new Argument('foo', 'Foo argument.'), $this->Command->CommandDefinition->getArguments()[0]);
        $this->assertEquals(new Option('bar', 'b', 'Bar option.'), $this->Command->CommandDefinition->getOptions()[0]);
    }

    public function testCommandStart()
    {
        $this->assertEquals(ExitStatus::SUCCESS, $this->Command->start(['foo']));
        $this->assertEquals(ExitStatus::ERROR, $this->Command->start(['test']));
        $this->assertEquals(ExitStatus::SUCCESS, $this->Command->start(['test', '--bar']));
        $this->assertEquals(ExitStatus::SUCCESS, $this->Command->start(['test', '-b']));
        $this->assertEquals(ExitStatus::ERROR, $this->Command->start(['test', '--test']));
    }

    public function testRequiredArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->Command->start([]);
    }
}