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

use core\CollectionInterface;
use core\database\Database;
use core\Logger;

/**
 * EntityCollection class
 *
 * TODO
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class EntityCollection implements CollectionInterface
{
	/**
	 * @var array $Entities An array containing all Entities of the EntityCollection
	 */
	private $Entities = array();

	/**
	 * @var string $entity The name of the entity.
	 */
	private $entity;
	
	/**
	 * @var string $EntityConfiguration The configuration of the entity.
	 */
	private $EntityConfiguration;

	/**
	 * @var string $fieldQuery TODO.
	 */
	private $fieldQuery;

	/**
	 * @var string $whereStmt TODO.
	 */
	private $whereStmt;
	
	/**
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct($entity) {
		$this->entity = $entity;
		
		$this->EntityConfiguration = new EntityConfiguration($this->entity);

		$this->setFieldQuery();
	}	

	/**
	 * setFieldQuery
	 * 
	 * TODO
	 */
	private function setFieldQuery() {
		$fieldQuery = "";

		foreach($this->EntityConfiguration->getMapping() as $key => $value) {
			/*$column = isset($value["column"]) ? $value["column"] : $key;
			$fieldQuery .= $column.' AS '.$key.', ';*/

			if(isset($value["column"])) {
				$fieldQuery .= $value["column"].' AS ';
			}

			$fieldQuery .= $key.', ';
		}

		$this->fieldQuery = rtrim($fieldQuery, ', ');
	}

	/**
	 * execute
	 * 
	 * TODO
	 */
	private function execute() {
		$Database = new Database();

		$query = "SELECT ";
		$query .= $this->fieldQuery;
		$query .= " FROM ";
		$query .= $this->EntityConfiguration->getTable();
		$query .= $this->getWhereStmt();
		
		$stmt = $Database->prepare($query);
		
		Logger::debug($query);  

		$stmt->execute();

		while ($properties = $stmt->fetch($Database::FETCH_ASSOC)) {        
			// TODO: Entity factory?
			$Entity = new $this->entity();
			foreach($properties as $property => $value) {
				$Entity->$property = $value;
			}		
			$this->Entities[] = $Entity;
		}
	}	
		
	/**
	 * getAll
	 * 
	 * TODO
	 */
	public function getAll() {
		$this->execute();

		return $this->Entities;
	}
	
	/**
	 * getById
	 * 
	 * TODO
	 */
	public function getById($id) {
		$this->where($this->EntityConfiguration->getIdColumn()." = ".$id);
		$this->execute();

		return $this->Entities[0];
	}

	/**
	 * getFirst
	 * 
	 * TODO
	 */
	public function getFirst() {
		$this->execute();

		return $this->Entities[0];
	}

	/**
	 * getLast
	 * 
	 * TODO
	 */
	public function getLast() {
		$this->execute();

		return end($this->Entities);
	}

	/**
	 * getWhereStmt
	 * 
	 * TODO
	 */
	private function getWhereStmt() {
		if(strlen($this->whereStmt) > 0) {
			return " WHERE ".$this->whereStmt;
		}

		return "";
	}

	/**
	 * where
	 * 
	 * TODO
	 */
	public function where($condition) {
		$this->whereStmt .= $condition;

		return $this;
	}
}
?>