<?php
/**
 * TODO
 */

namespace Avolutions\Command;

use Avolutions\Core\Application;
use Avolutions\Database\Database;
use Exception;
use ReflectionException;

/**
 * TODO
 */
class DatabaseMigrateCommand extends Command
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
     * @throws ReflectionException
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