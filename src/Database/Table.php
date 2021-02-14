<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

namespace Avolutions\Database;

/**
 * Table class
 *
 * The table class provides a bunch of methods to perform schema changes on database tables.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Table
{
	/**
	 * @var string INDEX A constant for the string "INDEX"
	 */
	const INDEX = 'INDEX';

	/**
	 * @var string PRIMARY A constant for the string "PRIMARY KEY"
	 */
	const PRIMARY = 'PRIMARY KEY';

	/**
	 * @var string UNIQUE A constant for the string "UNIQUE"
	 */
	const UNIQUE = 'UNIQUE';

	/**
	 * @var string RESTRICT A constant for the string "RESTRICT"
	 */
	const RESTRICT = 'RESTRICT';

	/**
	 * @var string CASCADE A constant for the string "CASCADE"
	 */
	const CASCADE = 'CASCADE';

	/**
	 * @var string SETNULL A constant for the string "SET NULL"
	 */
	const SET_NULL = 'SET NULL';

	/**
	 * @var string NOACTION A constant for the string "NO ACTION"
	 */
	const NO_ACTION = 'NO ACTION';

	/**
	 * create
	 *
	 * Creates a new database table if not exists.
	 *
	 * @param string $tableName The name of the table.
	 * @param array $Columns An array with Column objects to create the table.
	 */
    public static function create($tableName, $Columns)
    {
		$query = 'CREATE TABLE IF NOT EXISTS `'.$tableName.'` (';

		foreach ($Columns as $Column) {
			$query .= $Column->getPattern().',';
		}
		$query = rtrim($query, ',');
		$query .= ')';

		$Database = new Database();
		$Database->query($query);
	}

	/**
	 * addColumn
	 *
	 * Adds a new column to an existing table.
	 *
	 * @param string $tableName The name of the table.
	 * @param Column $Column A Column object to add to the table.
	 * @param string $after The name of an existing column to add the new Column after it.
	 */
    public static function addColumn($tableName, $Column, $after = null)
    {
		$query = 'ALTER TABLE `'.$tableName.'` ADD '.$Column->getPattern();

		if ($after != null) {
			$query .= ' AFTER `'.$after.'`';
		}

		$Database = new Database();
		$Database->query($query);
	}

	/**
	 * removeColumn
	 *
	 * Removes a column from an existing table.
	 *
	 * @param string $tableName The name of the table.
	 * @param string $columnName The name of the column that should be removed.
	 */
    public static function removeColumn($tableName, $columnName)
    {
		$query = 'ALTER TABLE `'.$tableName.'` DROP COLUMN '.$columnName;

		$Database = new Database();
		$Database->query($query);
	}

	/**
	 * addIndex
	 *
	 * Adds a new index to an existing table.
	 *
	 * @param string $tableName The name of the table.
	 * @param string $indexType The type of the index, one of the following constants should be used: INDEX, PRIMARY, UNIQUE.
	 * @param array $columnNames An array with one or more column names which are included in the index.
	 * @param string $indexName The name of the index.
	 */
    public static function addIndex($tableName, $indexType, $columnNames, $indexName = null)
    {
		$query = 'ALTER TABLE `'.$tableName.'` ADD '.$indexType.' ';

		if ($indexName != null) {
			$query .= '`'.$indexName.'` ';
		}

		$query .= '(';
		foreach ($columnNames as $columnName) {
			$query .= '`'.$columnName.'`,';
		}
		$query = rtrim($query, ',');
		$query .= ')';

		$Database = new Database();
		$Database->query($query);
	}

	/**
	 * addForeignKeyConstraint
	 *
	 * Adds a new foreign key constraint to the table.
	 *
	 * @param string $tableName The name of the table.
	 * @param string $columnName The name of the column.
	 * @param string $referenceTableName The name of the referenced table.
	 * @param string $referenceColumnName The name of the referenced column.
	 * @param string $onDelete The operation that will be performed on delete, one of the following constants should be used: RESTRICT, CASCADE, SETNULL, NOACTION.
	 * @param string $onUpdate The operation that will be performed on update, one of the following constants should be used: RESTRICT, CASCADE, SETNULL, NOACTION.
	 * @param string $constraintName The name of the constraint.
	 */
    public static function addForeignKeyConstraint(
        $tableName,
        $columnName,
        $referenceTableName,
        $referenceColumnName,
        $onDelete = Table::RESTRICT,
        $onUpdate = Table::RESTRICT,
        $constraintName = null
    ) {
        $query = 'ALTER TABLE `'.$tableName.'` ADD CONSTRAINT ';
        if ($constraintName != null) {
            $query .= '`'.$constraintName.'` ';
        }
        $query .= 'FOREIGN KEY (`'.$columnName.'`) REFERENCES `'.$referenceTableName.'`(`'.$referenceColumnName.'`) ON DELETE '.$onDelete.' ON UPDATE '.$onUpdate;

        $Database = new Database();
        $Database->query($query);
	}
}