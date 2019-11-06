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
	 * @var string $EntityMapping TODO.
	 */
	private $EntityMapping;

	/**
	 * @var string $fieldQuery TODO.
	 */
	private $fieldQuery;

	/**
	 * @var string $limitClause TODO.
	 */
	private $limitClause;

	/**
	 * @var string $orderByClause TODO.
	 */
	private $orderByClause;

	/**
	 * @var string $whereClause TODO.
	 */
	private $whereClause;
	
	/**
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct($entity) {
		$this->entity = $entity;
		
		$this->EntityConfiguration = new EntityConfiguration($this->entity);
		$this->EntityMapping = $this->EntityConfiguration->getMapping();

		$this->setFieldQuery();
	}	

	/**
	 * setFieldQuery
	 * 
	 * TODO
	 */
	private function setFieldQuery() {
		$fieldQuery = "";

		foreach($this->EntityMapping as $key => $value) {
			$fieldQuery .= $value["column"].' AS '.$key.', ';
		}

		$this->fieldQuery = rtrim($fieldQuery, ", ");
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
		$query .= $this->getWhereClause();
		$query .= $this->getOrderByClause();
		$query .= $this->getLimitClause();
		
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
	 * limit
	 * 
	 * TODO
	 */
	public function limit($rowCount, $offset = 0) {
		$this->limitClause = $rowCount;
		if($offset > 0) {
			$this->limitClause .= " OFFSET ".$offset;
		}

		return $this;
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
		$this->limit(1)->execute();

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
	 * getLimitClause
	 * 
	 * TODO
	 */
	private function getLimitClause() {
		if(strlen($this->limitClause) > 0) {
			return " LIMIT ".$this->limitClause;
		}

		return "";
	}

	/**
	 * getOrderByClause
	 * 
	 * TODO
	 */
	private function getOrderByClause() {
		if(strlen($this->orderByClause) > 0) {
			return " ORDER BY ".rtrim($this->orderByClause, ", ");
		}

		return "";
	}

	/**
	 * getWhereClause
	 * 
	 * TODO
	 */
	private function getWhereClause() {
		if(strlen($this->whereClause) > 0) {
			return " WHERE ".$this->whereClause;
		}

		return "";
	}

	/**
	 * orderBy
	 * 
	 * TODO
	 */
	public function orderBy($field, $descending = false) {
		$this->orderByClause .= $this->EntityMapping->$field["column"];
		if($descending) {
			$this->orderByClause .= " DESC";
		}
		$this->orderByClause .= ", ";

		return $this;
	}

	/**
	 * where
	 * 
	 * TODO
	 */
	public function where($condition) {
		$this->whereClause .= $condition;

		return $this;
	}
}
?>