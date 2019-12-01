<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		https://github.com/avolutions/avolutions
 */
 
namespace core\orm;

use core\orm\EntityMapping;

/**
 * EntityConfiguration class
 *
 * The EntityConfiguration class provides all configurations for an entity, 
 * e.g. the mapping and the related database table name.
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class EntityConfiguration
{
	/**
	 * @var string $entity The name of the entity.
	 */
	private $entity;
	
	/**
	 * @var string $table The name of the related database table.
	 */
	private $table;
	
	/**
	 * @var string $idColumn The name of the ID column in the database table.
	 */
	private $idColumn;
	
	/**
	 * @var object $mapping The mapping between the entity and the database table.
	 */
	private $Mapping;
	
	/**
	 * __construct
	 * 
	 * Creates a new EntityConfiguration for the given Entity type and loads the corresponding 
	 * EntityMapping, table and id column.
	 * 
	 * @param string $entity The name of the Entity type.
	 */
	public function __construct($entity) {		
		$this->entity = $entity;
		$this->loadMapping();
		$this->setTable();
		$this->setIdColumn();
	}	
	
	/**
	 * loadMapping
	 * 
	 * Loads the EntityMapping for the given entity.
	 */
	private function loadMapping() {	
		$this->Mapping = new EntityMapping($this->entity);
	}
	
	/**
	 * getTable
	 * 
	 * Returns the related database table of the entity.
	 * 
	 * @return string $this->table
	 */
	public function getTable() {
		return $this->table;
	}
	
	/**
	 * setTable
	 * 
	 * Sets the name of the corresponding table for the entity.
	 */
	private function setTable() {	
		$this->table = $this->entity;
	}
	
	/**
	 * getIdColumn
	 * 
	 * Returns the name of the ID column in the database table.
	 * 
	 * @return string $this->idColumn
	 */
	public function getIdColumn() {
		return $this->idColumn;
	}
	
	/**
	 * setIdColumn
	 * 
	 * Sets the name of the ID column in the database table.
	 */
	private function setIdColumn() {	
		$this->idColumn = $this->getTable()."ID";
	}

	/**
	 * getMapping
	 * 
	 * Returns the mapping between the entity and the database table.
	 * 
	 * @return EntityMapping $this->idColumn
	 */
	public function getMapping() {	
		return $this->Mapping;
	}
}
?>