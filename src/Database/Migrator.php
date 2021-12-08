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

namespace Avolutions\Database;

use Avolutions\Core\Application;
use Exception;
use InvalidArgumentException;
use PDO;
use PDOException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Migrator class
 *
 * Handles migration of the database.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.9.0
 */
class Migrator
{
    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * Database instance.
     *
     * @var Database $Database
     */
    private Database $Database;

    /**
     * __construct
     *
     * Creates new Migrator instance.
     *
     * @param Application $Application Application instance.
     * @param Database $Database Database instance.
     */
    public function __construct(Application $Application, Database $Database)
    {
        $this->Application = $Application;
        $this->Database = $Database;
    }

    /**
     * migrate
     *
     * Executes all migrations from the application database directory.
     *
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws Exception
     */
    public function migrate()
    {
        $migrationsToExecute = [];
        $migrationFiles = array_map('basename', glob($this->Application->getDatabasePath() . '*.php'));

        $executedMigrations = $this->getExecutedMigrations();

        foreach ($migrationFiles as $migrationFile) {
            $migrationClassName = $this->Application->getDatabaseNamespace() . pathinfo(
                    $migrationFile,
                    PATHINFO_FILENAME
                );

            $Migration = $this->Application->get($migrationClassName);

            // only use Migration extending the AbstractMigration
            if (!$Migration instanceof AbstractMigration) {
                throw new RuntimeException('Migration "' . $migrationClassName . '" has to extend AbstractMigration');
            }

            // version has to be an integer use
            if (!is_int($Migration->version)) {
                throw new InvalidArgumentException(
                    'The version of the migration "' . $migrationClassName . '" has to be an integer.'
                );
            }

            // only execute Migration if not already executed
            if (!in_array($Migration->version, array_keys($executedMigrations))) {
                $migrationsToExecute[$Migration->version] = $Migration;
            }
        }

        ksort($migrationsToExecute);

        foreach ($migrationsToExecute as $version => $Migration) {
            $Migration->migrate();

            $stmt = $this->Database->prepare('INSERT INTO migration (Version, Name) VALUES (?, ?)');
            $stmt->execute([$version, (new ReflectionClass($Migration))->getShortName()]);
        }
    }

    /**
     * getExecutedMigrations
     *
     * Gets all executed migrations from the database and return the versions.
     *
     * @return array The version numbers of the executed migrations.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getExecutedMigrations(): array
    {
        $executedMigrations = [];

        try {
            $stmt = $this->Database->prepare('SELECT * FROM migration');
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $executedMigrations[$row['Version']] = [
                    'name' => $row['Name'],
                    'date' => $row['CreateDate']
                ];
            }
        } catch (PDOException $ex) {
            // 1146 = Table 'migration' doesn't exist
            if ($ex->errorInfo[1] == 1146) {
                $this->createMigrationTable();
            } else {
                throw $ex;
            }
        }

        return $executedMigrations;
    }

    /**
     * createMigrationTable
     *
     * Creates the table to store executed migrations.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function createMigrationTable()
    {
        $columns = [];
        $columns[] = new Column('MigrationID', ColumnType::INT, 255, null, Column::NOT_NULL, true, true);
        $columns[] = new Column('Version', ColumnType::BIGINT, 255);
        $columns[] = new Column('Name', ColumnType::VARCHAR, 255);
        $columns[] = new Column('CreateDate', ColumnType::DATETIME, null, Column::CURRENT_TIMESTAMP);

        $Table = $this->Application->make(Table::class, ['name' => 'migration']);
        $Table->create($columns);
    }
}