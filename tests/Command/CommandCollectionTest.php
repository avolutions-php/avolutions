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

use Avolutions\Command\CommandCollection;

class CommandCollectionTest extends TestCase
{
    public function testCount()
    {
        $CommandCollection = new CommandCollection();

        $this->assertEquals(11, $CommandCollection->count());
    }

    public function testGetAll()
    {
        $CommandCollection = new CommandCollection();

        $commands = [
            'create-command' => 'Avolutions\Command\CreateCommandCommand',
            'create-controller' => 'Avolutions\Command\CreateControllerCommand',
            'create-event' => 'Avolutions\Command\CreateEventCommand',
            'create-listener' => 'Avolutions\Command\CreateListenerCommand',
            'create-mapping' => 'Avolutions\Command\CreateMappingCommand',
            'create-migration' => 'Avolutions\Command\CreateMigrationCommand',
            'create-model' => 'Avolutions\Command\CreateModelCommand',
            'create-validator' => 'Avolutions\Command\CreateValidatorCommand',
            'database-migrate' => 'Avolutions\Command\DatabaseMigrateCommand',
            'database-status' => 'Avolutions\Command\DatabaseStatusCommand',
            'register-listener' => 'Avolutions\Command\RegisterListenerCommand'
        ];

        $this->assertEquals($commands, $CommandCollection->getAll());
    }

    public function testGetByName()
    {
        $CommandCollection = new CommandCollection();

        $this->assertEquals('Avolutions\Command\CreateCommandCommand', $CommandCollection->getByName('create-command'));
        $this->assertEquals('Avolutions\Command\CreateCommandCommand', $CommandCollection->getByName('CREATE-COMMAND'));
        $this->assertEquals(null,$CommandCollection->getByName('unknown'));
    }
}