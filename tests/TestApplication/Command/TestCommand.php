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

namespace TestApplication\Command;

use Avolutions\Command\AbstractCommand;
use Avolutions\Command\Argument;
use Avolutions\Command\ExitStatus;
use Avolutions\Command\Option;

class TestCommand extends AbstractCommand
{
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
}