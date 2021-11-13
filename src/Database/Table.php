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

/**
 * Table class
 *
 * The table class provides a bunch of methods to perform schema changes on database tables.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class Table
{
    /**
     * A constant for the string "INDEX"
     *
     * @var string INDEX
     */
    public const INDEX = 'INDEX';

    /**
     * A constant for the string "PRIMARY KEY"
     *
     * @var string PRIMARY
     */
    public const PRIMARY = 'PRIMARY KEY';

    /**
     * A constant for the string "UNIQUE"
     *
     * @var string UNIQUE
     */
    public const UNIQUE = 'UNIQUE';

    /**
     * A constant for the string "RESTRICT"
     *
     * @var string RESTRICT
     */
    public const RESTRICT = 'RESTRICT';

    /**
     * A constant for the string "CASCADE"
     *
     * @var string CASCADE
     */
    public const CASCADE = 'CASCADE';

    /**
     * A constant for the string "SET NULL"
     *
     * @var string SET_NULL
     */
    public const SET_NULL = 'SET NULL';

    /**
     * A constant for the string "NO ACTION"
     *
     * @var string NO_ACTION
     */
    public const NO_ACTION = 'NO ACTION';

    /**
     * Database instance.
     *
     * @var Database $Database
     */
    private Database $Database;

    /**
     * Name of the table.
     *
     * @var string $name
     */
    private string $name;

    /**
     * __construct
     *
     * Creates a new Table object.
     *
     * @param Database $Database Database instance.
     * @param string $name Name of the table.
     */
    public function __construct(Database $Database, string $name)
    {
        $this->Database = $Database;
        $this->name = $name;
    }

    /**
     * create
     *
     * Creates a new database table if not exists.
     *
     * @param array $Columns An array with Column objects to create the table.
     */
    public function create(array $Columns)
    {
        $query = 'CREATE TABLE IF NOT EXISTS `' . $this->name . '` (';

        foreach ($Columns as $Column) {
            $query .= $Column->getPattern() . ',';
        }
        $query = rtrim($query, ',');
        $query .= ')';

        $this->Database->query($query);
    }

    /**
     * addColumn
     *
     * Adds a new column to an existing table.
     *
     * @param Column $Column A Column object to add to the table.
     * @param string|null $after The name of an existing column to add the new Column after it.
     */
    public function addColumn(Column $Column, ?string $after = null)
    {
        $query = 'ALTER TABLE `' . $this->name . '` ADD ' . $Column->getPattern();

        if ($after != null) {
            $query .= ' AFTER `' . $after . '`';
        }

        $this->Database->query($query);
    }

    /**
     * removeColumn
     *
     * Removes a column from an existing table.
     *
     * @param string $columnName The name of the column that should be removed.
     */
    public function removeColumn(string $columnName)
    {
        $query = 'ALTER TABLE `' . $this->name . '` DROP COLUMN ' . $columnName;

        $this->Database->query($query);
    }

    /**
     * addIndex
     *
     * Adds a new index to an existing table.
     *
     * @param string $indexType The type of the index, one of the following constants should be used: INDEX, PRIMARY, UNIQUE.
     * @param array $columnNames An array with one or more column names which are included in the index.
     * @param string|null $indexName The name of the index.
     */
    public function addIndex(string $indexType, array $columnNames, ?string $indexName = null)
    {
        $query = 'ALTER TABLE `' . $this->name . '` ADD ' . $indexType . ' ';

        if ($indexName != null) {
            $query .= '`' . $indexName . '` ';
        }

        $query .= '(';
        foreach ($columnNames as $columnName) {
            $query .= '`' . $columnName . '`,';
        }
        $query = rtrim($query, ',');
        $query .= ')';

        $this->Database->query($query);
    }

    /**
     * addForeignKeyConstraint
     *
     * Adds a new foreign key constraint to the table.
     *
     * @param string $columnName The name of the column.
     * @param string $referenceTableName The name of the referenced table.
     * @param string $referenceColumnName The name of the referenced column.
     * @param string $onDelete The operation that will be performed on delete, one of the following constants should be used: RESTRICT, CASCADE, SET_NULL, NO_ACTION.
     * @param string $onUpdate The operation that will be performed on update, one of the following constants should be used: RESTRICT, CASCADE, SET_NULL, NO_ACTION.
     * @param string|null $constraintName The name of the constraint.
     */
    public function addForeignKeyConstraint(
        string $columnName,
        string $referenceTableName,
        string $referenceColumnName,
        string $onDelete = Table::RESTRICT,
        string $onUpdate = Table::RESTRICT,
        ?string $constraintName = null
    ) {
        $query = 'ALTER TABLE `' . $this->name . '` ADD CONSTRAINT ';
        if ($constraintName != null) {
            $query .= '`' . $constraintName . '` ';
        }
        $query .= 'FOREIGN KEY (`' . $columnName . '`) REFERENCES `' . $referenceTableName . '`(`' . $referenceColumnName . '`) ON DELETE ' . $onDelete . ' ON UPDATE ' . $onUpdate;

        $this->Database->query($query);
    }
}