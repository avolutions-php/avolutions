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

use PHPUnit\Framework\TestCase;

use Avolutions\Command\CommandCollection;
use Avolutions\Command\CreateCollectionCommand;
use Avolutions\Command\CreateCommandCommand;
use Avolutions\Command\CreateControllerCommand;
use Avolutions\Command\CreateEventCommand;
use Avolutions\Command\CreateListenerCommand;
use Avolutions\Command\CreateMappingCommand;
use Avolutions\Command\CreateMigrationCommand;
use Avolutions\Command\CreateModelCommand;
use Avolutions\Command\CreateValidatorCommand;
use Avolutions\Command\DatabaseMigrateCommand;
use Avolutions\Command\DatabaseStatusCommand;
use Avolutions\Command\RegisterListenerCommand;
use Avolutions\Core\Application;

class CommandCollectionTest extends TestCase
{
    private CommandCollection $CommandCollection;

    public function setUp(): void
    {
        $Application = new Application(__DIR__);
        $this->CommandCollection = new CommandCollection($Application);
    }

    public function testCount()
    {
        $this->assertEquals(12, $this->CommandCollection->count());
    }

    public function testGetAll()
    {
        $commands = [
            'create-collection' => CreateCollectionCommand::class,
            'create-command' => CreateCommandCommand::class,
            'create-controller' => CreateControllerCommand::class,
            'create-event' => CreateEventCommand::class,
            'create-listener' => CreateListenerCommand::class,
            'create-mapping' => CreateMappingCommand::class,
            'create-migration' => CreateMigrationCommand::class,
            'create-model' => CreateModelCommand::class,
            'create-validator' => CreateValidatorCommand::class,
            'database-migrate' => DatabaseMigrateCommand::class,
            'database-status' => DatabaseStatusCommand::class,
            'register-listener' => RegisterListenerCommand::class
        ];

        $this->assertEquals($commands, $this->CommandCollection->getAll());
    }

    public function testGetByName()
    {
        $this->assertEquals(CreateCommandCommand::class, $this->CommandCollection->getByName('create-command'));
        $this->assertEquals(CreateCommandCommand::class, $this->CommandCollection->getByName('CREATE-COMMAND'));
        $this->assertEquals(null, $this->CommandCollection->getByName('unknown'));
    }
}