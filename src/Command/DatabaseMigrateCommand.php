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
    /**
     * @inheritdoc
     */
    protected static string $name = 'database-migrate';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Executes all new migrations.';

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function execute(): int
    {
        try {
            Database::migrate();
            $this->Console->writeLine('Migrations executed successfully', 'success');
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