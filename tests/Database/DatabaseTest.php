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

namespace Avolutions\Test\Database;

use PHPUnit\Framework\TestCase;

use Avolutions\Core\Application;
use Avolutions\Database\Migrator;
use Avolutions\Database\Database;

class DatabaseTest extends TestCase
{
    private Database $Database;

    protected function setUp(): void
    {
        new Application(__DIR__);
        $this->Database = application(Database::class);

        $query = 'DROP TABLE IF EXISTS `migration`';
        $stmt = $this->Database->prepare($query);
        $stmt->execute();
    }

    public function testDatabaseConnection()
    {
        $this->assertInstanceOf('\PDO', $this->Database);
    }

    public function testMigrationTableCanBeCreated()
    {
        $table = [
            [
                'Field' => 'MigrationID',
                'Type' => 'int(255)',
                'Null' => 'NO',
                'Key' => 'PRI',
                'Default' => '',
                'Extra' => 'auto_increment'
            ],
            [
                'Field' => 'Version',
                'Type' => 'bigint(255)',
                'Null' => 'NO',
                'Key' => '',
                'Default' => '',
                'Extra' => '',
            ],
            [
                'Field' => 'Name',
                'Type' => 'varchar(255)',
                'Null' => 'NO',
                'Key' => '',
                'Default' => '',
                'Extra' => ''
            ],
            [
                'Field' => 'CreateDate',
                'Type' => 'datetime',
                'Null' => 'NO',
                'Key' => '',
                'Default' => 'CURRENT_TIMESTAMP',
                'Extra' => ''
            ]
        ];

        $Migrator = application(Migrator::class);
        $Migrator->migrate();

        $query = 'DESCRIBE migration';
        $stmt = $this->Database->prepare($query);
        $stmt->execute();

        $rows = $stmt->fetchAll($this->Database::FETCH_ASSOC);

        // workaround because unix system return 'CURRENT_TIMESTAMP' and windows returns 'current_timestamp()'
        $rows[3]['Default'] = str_replace('current_timestamp()', 'CURRENT_TIMESTAMP', $rows[3]['Default']);

        $this->assertEquals($rows, $table);
    }
}