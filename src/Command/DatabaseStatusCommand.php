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
    protected static string $name = 'database-status';

    protected static string $description = 'Shows all executed migrations.';

    public function execute(): int
    {
        try {
            $this->Console->writeLine('Executed migrations:', 'success');
            $columns = [
                ['Version', 'Name', 'Date']
            ];

            foreach (Database::getExecutedMigrations() as $version => $migration) {
                $columns[] = [
                    $version,
                    $migration['name'],
                    $migration['date']
                ];
            }
            $ConsoleTable = new ConsoleTable($this->Console, $columns);
            $ConsoleTable->render();

            return ExitStatus::SUCCESS;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function initialize(): void
    {

    }
}