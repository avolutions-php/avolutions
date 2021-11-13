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

use Avolutions\Console\Console;
use Avolutions\Console\ConsoleTable;
use Avolutions\Core\Application;

use Avolutions\Database\Migrator;

/**
 * DatabaseStatusCommand class
 *
 * Shows all executed migrations.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class DatabaseStatusCommand extends AbstractCommand
{
    protected static string $name = 'database-status';

    protected static string $description = 'Shows all executed migrations.';
    private Migrator $Migrator;

    public function __construct(Application $Application, Migrator $Migrator, ?Console $Console = null)
    {
        parent::__construct($Application, $Console);
        $this->Migrator = $Migrator;
    }

    public function execute(): int
    {
        $this->Console->writeLine('Executed migrations:', 'success');
        $columns = [
            ['Version', 'Name', 'Date']
        ];

        foreach ($this->Migrator->getExecutedMigrations() as $version => $migration) {
            $columns[] = [
                $version,
                $migration['name'],
                $migration['date']
            ];
        }
        $ConsoleTable = new ConsoleTable($this->Console, $columns);
        $ConsoleTable->render();

        return ExitStatus::SUCCESS;
    }

    public function initialize(): void
    {
    }
}