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

/**
 * EntityConfiguration class
 *
 * TODO
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
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct($entity) {
		print '__construct()';		
		
		$this->entity = $entity;
		$this->setTable();
		$this->setIdColumn();
		
		print_r($this);
	}	
	
	/**
	 * getTable
	 * 
	 * TODO
	 */
	public function getTable() {
		return $this->table;
	}
	
	/**
	 * setTable
	 * 
	 * TODO
	 */
	private function setTable() {	
		$this->table = $this->entity;
	}
	
	/**
	 * getIdColumn
	 * 
	 * TODO
	 */
	public function getIdColumn() {
		return $this->idColumn;
	}
	
	/**
	 * setIdColumn
	 * 
	 * TODO
	 */
	private function setIdColumn() {	
		$this->idColumn = $this->getTable()."ID";
	}
}
?>