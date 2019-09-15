<?php
	use core\database\Table;
	use core\database\Column;
	
	class CreateMigrationTable {
		public $version = "1";
		
		public function migrate() {
			$columns = array();
			$columns[] = new Column("MigrationID", Column::INT, 255, null, null, true, true);
			$columns[] = new Column("Version", Column::VARCHAR, 255);
			$columns[] = new Column("Name", Column::VARCHAR, 255);
			$columns[] = new Column("CreateDate", Column::DATETIME, NULL, Column::CURRENT_TIMESTAMP);		
			Table::create("migration", $columns);
		}
	}
?>