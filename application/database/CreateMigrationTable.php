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

namespace Application\Database;

use Avolutions\Database\Table;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\AbstractMigration;

/**
 * CreateMigrationTable class
 *
 * Contains the migration to create the migration table.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class CreateMigrationTable extends AbstractMigration 
{
    /**
	 * @var int version The version of the migration
	 */
    public $version = 1;
    
    /**
	 * migrate
	 * 
	 * Creates the table "migration" with the columns "MigrationID", "Version", "Name, and "CreateDate".
	 */
    public function migrate()
    {
        $columns = [];
        $columns[] = new Column('MigrationID', ColumnType::INT, 255, null, null, true, true);
        $columns[] = new Column('Version', ColumnType::BIGINT, 255);
        $columns[] = new Column('Name', ColumnType::VARCHAR, 255);
        $columns[] = new Column('CreateDate', ColumnType::DATETIME, null, Column::CURRENT_TIMESTAMP);	
        Table::create('migration', $columns);
    }
}