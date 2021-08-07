<?php
/**
 * TODO
 */

namespace Avolutions\Command;

use Avolutions\Console\ConsoleTable;
use Avolutions\Core\Application;
use Avolutions\Database\Database;
use Exception;
use ReflectionException;

/**
 * TODO
 */
class DatabaseStatusCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected static string $name = 'database-status';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Shows all executed migrations.';

    /**
     * @inheritdoc
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