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

namespace Avolutions\Command;

use Avolutions\Console\ConsoleTable;
use Avolutions\Database\Database;
use Exception;

/**
 * DatabaseStatusCommand class
 *
 * Shows all executed migrations.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class DatabaseStatusCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    protected static string $name = 'database-status';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Shows all executed migrations.';

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function execute(): int
    {
        try {
            $this->Console->writeLine('Executed migrations:', 'success');
            $ConsoleTable = new ConsoleTable($this->Console, ['Version', 'Name', 'Date']);
            foreach (Database::getExecutedMigrations() as $version => $migration) {
                $ConsoleTable->addRow([$version, $migration['name'], $migration['date']]);
            }
            $ConsoleTable->render();
            return 1;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @inheritdoc
     */
    public function initialize(): void
    {

    }
}