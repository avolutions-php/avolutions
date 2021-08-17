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

use Avolutions\Database\Database;

use Exception;

/**
 * DatabaseMigrateCommand class
 *
 * Executes all new migrations.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class DatabaseMigrateCommand extends AbstractCommand
{
    protected static string $name = 'database-migrate';

    protected static string $description = 'Executes all new migrations.';

    public function execute(): int
    {
        try {
            Database::migrate();
            $this->Console->writeLine('Migrations executed successfully', 'success');
            return ExitStatus::SUCCESS;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function initialize(): void
    {

    }
}