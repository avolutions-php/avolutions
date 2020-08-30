<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2020 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */

use PHPUnit\Framework\TestCase;

use Avolutions\Database\Database;

class DatabaseTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $Database = new Database();

        $this->assertInstanceOf('\PDO', $Database);
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
                'Default' => 'current_timestamp()',
                'Extra' => ''
            ]
        ];
 
        Database::migrate();

        $Database = new Database();

        $query = 'DESCRIBE migration';
        $stmt = $Database->prepare($query);
		$stmt->execute();

        $rows = $stmt->fetchAll($Database::FETCH_ASSOC);

        print_r($rows);

        $this->assertEquals($rows, $table);
    }
}