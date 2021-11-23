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

use Avolutions\Core\Application;
use Avolutions\Database\Migrator;
use Throwable;

/**
 * DatabaseMigrateCommand class
 *
 * Executes all new migrations.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class DatabaseMigrateCommand extends AbstractCommand
{
    protected static string $name = 'database-migrate';

    protected static string $description = 'Executes all new migrations.';
    private Migrator $Migrator;

    public function __construct(Application $Application, Migrator $Migrator, ?Console $Console = null)
    {
        parent::__construct($Application, $Console);
        $this->Migrator = $Migrator;
    }

    public function execute(): int
    {
        try {
            $this->Migrator->migrate();
            $this->Console->writeLine('Migrations executed successfully', 'success');
            return ExitStatus::SUCCESS;
        } catch (Throwable $e) {
            $this->Console->writeLine(
                interpolate('Error while executing migrations: {0} in {1}', [$e->getMessage(), $e->getTraceAsString()]),
                'error'
            );
            return ExitStatus::ERROR;
        }
    }

    public function initialize(): void
    {
    }
}