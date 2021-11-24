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

namespace Avolutions\Test\TestCases\Command;

use Avolutions\Command\CommandDispatcher;
use Avolutions\Command\ExitStatus;
use Avolutions\Test\TestCase;

class CommandDispatcherTest extends TestCase
{
    public function setUp(): void
    {
        $this->mockTestApplication();
    }

    public function testCommandCanBeDispatched()
    {
        $CommandDispatcher = application(CommandDispatcher::class);

        $this->assertEquals(ExitStatus::SUCCESS, $CommandDispatcher->dispatch('test-command foo'));
        $this->assertEquals(ExitStatus::ERROR, $CommandDispatcher->dispatch('test-command test'));
        $this->assertEquals(ExitStatus::SUCCESS, $CommandDispatcher->dispatch('test-command test --bar'));
        $this->assertEquals(ExitStatus::SUCCESS, $CommandDispatcher->dispatch('test-command test -b'));
        $this->assertEquals(ExitStatus::ERROR, $CommandDispatcher->dispatch('test-command test --test'));

        $this->assertEquals(ExitStatus::SUCCESS, $CommandDispatcher->dispatch(['test-command', 'foo']));
        $this->assertEquals(ExitStatus::ERROR, $CommandDispatcher->dispatch(['test-command', 'test']));
        $this->assertEquals(ExitStatus::SUCCESS, $CommandDispatcher->dispatch(['test-command', 'test', '--bar']));
        $this->assertEquals(ExitStatus::SUCCESS, $CommandDispatcher->dispatch(['test-command', 'test', '-b']));
        $this->assertEquals(ExitStatus::ERROR, $CommandDispatcher->dispatch(['test-command', 'test', '--test']));
    }

    public function testCommandHelper()
    {
        $this->assertEquals(ExitStatus::SUCCESS, command('test-command foo'));
        $this->assertEquals(ExitStatus::ERROR, command('test-command test'));
        $this->assertEquals(ExitStatus::SUCCESS, command('test-command test --bar'));
        $this->assertEquals(ExitStatus::SUCCESS, command('test-command test -b'));
        $this->assertEquals(ExitStatus::ERROR, command('test-command test --test'));

        $this->assertEquals(ExitStatus::SUCCESS, command(['test-command', 'foo']));
        $this->assertEquals(ExitStatus::ERROR, command(['test-command', 'test']));
        $this->assertEquals(ExitStatus::SUCCESS, command(['test-command', 'test', '--bar']));
        $this->assertEquals(ExitStatus::SUCCESS, command(['test-command', 'test', '-b']));
        $this->assertEquals(ExitStatus::ERROR, command(['test-command', 'test', '--test']));
    }
}