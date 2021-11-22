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
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\Database;
use Avolutions\Database\Table;

class TableTest extends TestCase
{
    private Database $Database;

    private Table $Table;

    protected function setUp(): void
    {
        new Application(__DIR__);
        $this->Database = application(Database::class);
        $this->Table = new Table($this->Database, 'user');

        $query = 'DROP TABLE IF EXISTS `user`';
        $stmt = $this->Database->prepare($query);
        $stmt->execute();
    }

    private function createUserTable()
    {
        $columns = array();
        $columns[] = new Column('UserID', ColumnType::INT, 255, null, Column::NOT_NULL, true, true);
        $columns[] = new Column('Firstname', ColumnType::VARCHAR, 255);
        $columns[] = new Column('Lastname', ColumnType::VARCHAR, 255);
        $this->Table->create($columns);
    }

    public function getUserTable(): array|false
    {
        $query = 'DESCRIBE user';
        $stmt = $this->Database->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll($this->Database::FETCH_ASSOC);
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

        $rows = $this->getUserTable();

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
        $this->Table->addColumn(new Column('NewColumn', ColumnType::VARCHAR, 255));

        $rows = $this->getUserTable();

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
        $this->Table->addColumn(new Column('NewColumnAtPosition', ColumnType::VARCHAR, 255), 'Firstname');

        $rows = $this->getUserTable();

        $this->assertEquals($rows[2], $column);
    }

    public function testColumnCanBeRemovedFromTable()
    {
        $this->createUserTable();
        $this->Table->removeColumn('Firstname');

        $rows = $this->getUserTable();

        $this->assertCount(2, $rows);
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
        $this->Table->addIndex(Table::UNIQUE, ['Firstname']);

        $rows = $this->getUserTable();

        $this->assertEquals($rows[1], $column);
    }

    public function testForeignKeyConstraintCanBeAdded()
    {
        $this->createUserTable();
        $this->Table->addIndex(Table::INDEX, ['Firstname']);
        $this->Table->addForeignKeyConstraint(
            'Lastname',
            'user',
            'Firstname',
            Table::RESTRICT,
            Table::RESTRICT,
            'fk_constraint'
        );

        $query = 'SELECT * FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = \'avolutions\' AND REFERENCED_TABLE_NAME = \'user\'';
        $stmt = $this->Database->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch($this->Database::FETCH_ASSOC);

        $this->assertEquals('fk_constraint', $row['CONSTRAINT_NAME']);
        $this->assertEquals('avolutions', $row['TABLE_SCHEMA']);
        $this->assertEquals('user', $row['TABLE_NAME']);
        $this->assertEquals('Lastname', $row['COLUMN_NAME']);
        $this->assertEquals('avolutions', $row['REFERENCED_TABLE_SCHEMA']);
        $this->assertEquals('user', $row['REFERENCED_TABLE_NAME']);
        $this->assertEquals('Firstname', $row['REFERENCED_COLUMN_NAME']);
    }
}