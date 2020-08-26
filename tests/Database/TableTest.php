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

use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\Database;
use Avolutions\Database\Table;

class TableTest extends TestCase
{
    public function setUp() : void
    {
        $Database = new Database();

        $query = 'DROP TABLE `user`';
        $stmt = $Database->prepare($query);
		$stmt->execute();
    }

    private function createUserTable() 
    {
        $columns = array();
        $columns[] = new Column('UserID', ColumnType::INT, 255, null, null, true, true);
        $columns[] = new Column('Firstname', ColumnType::VARCHAR, 255);
        $columns[] = new Column('Lastname', ColumnType::VARCHAR, 255);	
        Table::create('user', $columns);
    }

    public function testTableCanBeCreated()
    {
        $table = [
            [
                'Field' => 'UserID',
                'Type' => 'int(255)',
                'Null' => 'NO',
                'Key' => 'PRI',
                'Default' => '',
                'Extra' => 'auto_increment'
            ],
            [
                'Field' => 'Firstname',
                'Type' => 'varchar(255)',
                'Null' => 'NO',
                'Key' => '',
                'Default' => '',
                'Extra' => ''
            ],
            [
                'Field' => 'Lastname',
                'Type' => 'varchar(255)',
                'Null' => 'NO',
                'Key' => '',
                'Default' => '',
                'Extra' => ''
            ]
        ];

        $this->createUserTable();        

        $Database = new Database();

        $query = 'DESCRIBE user';
        $stmt = $Database->prepare($query);
		$stmt->execute();

        $rows = $stmt->fetchAll($Database::FETCH_ASSOC);
        
        $this->assertEquals($rows, $table);
    }

    public function testColumnCanBeAddedToTable() 
    {
        $column = [
            'Field' => 'NewColumn',
            'Type' => 'varchar(255)',
            'Null' => 'NO',
            'Key' => '',
            'Default' => '',
            'Extra' => ''
        ];

        $this->createUserTable(); 
        Table::addColumn('user', new Column('NewColumn', ColumnType::VARCHAR, 255));

        $Database = new Database();

        $query = 'DESCRIBE user';
        $stmt = $Database->prepare($query);
		$stmt->execute();

        $rows = $stmt->fetchAll($Database::FETCH_ASSOC);
        
        $this->assertEquals($rows[3], $column);
    }

    public function testColumnCanBeAddedToTableAtSpecificPosition() 
    {
        $column = [
            'Field' => 'NewColumnAtPosition',
            'Type' => 'varchar(255)',
            'Null' => 'NO',
            'Key' => '',
            'Default' => '',
            'Extra' => ''
        ];
        
        $this->createUserTable(); 
        Table::addColumn('user', new Column('NewColumnAtPosition', ColumnType::VARCHAR, 255), 'Firstname');

        $Database = new Database();

        $query = 'DESCRIBE user';
        $stmt = $Database->prepare($query);
		$stmt->execute();

        $rows = $stmt->fetchAll($Database::FETCH_ASSOC);
        
        $this->assertEquals($rows[2], $column);
    }

    public function testColumnCanBeRemovedFromTable() 
    {
        $this->createUserTable();
        Table::removeColumn('user', 'Firstname');

        $Database = new Database();

        $query = 'DESCRIBE user';
        $stmt = $Database->prepare($query);
		$stmt->execute();

        $rows = $stmt->fetchAll($Database::FETCH_ASSOC);
        
        $this->assertEquals(count($rows), 2);
    }

    public function testIndexCanBeAddedToTable() 
    {
        $column = [
            'Field' => 'Firstname',
            'Type' => 'varchar(255)',
            'Null' => 'NO',
            'Key' => 'UNI',
            'Default' => '',
            'Extra' => ''
        ];

        $this->createUserTable();
        Table::addIndex('user', Table::UNIQUE, ['Firstname']);

        $Database = new Database();

        $query = 'DESCRIBE user';
        $stmt = $Database->prepare($query);
		$stmt->execute();

        $rows = $stmt->fetchAll($Database::FETCH_ASSOC);
        
        $this->assertEquals($rows[1], $column);
    }
}