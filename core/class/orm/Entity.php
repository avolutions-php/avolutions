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

use core\database\Database;
use core\Logger;

/**
 * Entity class
 *
 * TODO
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class Entity
{
	/**
	 * @var mixed $id The unique identifier of the entity.
	 */
	public $id;

	/**
	 * @var string $EntityConfiguration The configuration of the entity.
	 */
	private $EntityConfiguration;

	/**
	 * @var string $EntityMapping TODO.
	 */
	private $EntityMapping;
		
	
	/**
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct() {
		$this->EntityConfiguration = new EntityConfiguration(get_class($this));
		$this->EntityMapping = $this->EntityConfiguration->getMapping();
	}	
		
	/**
	 * save
	 * 
	 * TODO
	 */
	public function save() {		
		if($this->exists()) {
			$this->update();
		} else {
			$this->insert();
		}
	}	

	/**
	 * delete
	 * 
	 * TODO
	 */
	public function delete() {
		$values = array("id" => $this->id);	

		$query = "DELETE FROM ";
		$query .= $this->EntityConfiguration->getTable();
		$query .= " WHERE ";
		$query .= $this->EntityConfiguration->getIdColumn();
		$query .= " = :id";

		$this->execute($query, $values);
	}	

	/**
	 * insert
	 * 
	 * TODO
	 */
	private function insert() {
		$values = array();
		$columns = array();
		$parameters = array();

		foreach($this->EntityMapping as $key => $value) {
			$columns[] = $value["column"];
			$parameters[] = ":$key";
			$values[$key] = $this->$key;
		}	

		$query = "INSERT INTO ";
		$query .= $this->EntityConfiguration->getTable();
		$query .= " (";
		$query .= implode(", ", $columns);	
		$query .= ") VALUES (";
		$query .= implode(", ", $parameters);	
		$query .= ")";
		
		$this->execute($query, $values);
	}	

	/**
	 * update
	 * 
	 * TODO
	 */
	private function update() {
		$values = array();

		$query = "UPDATE ";
		$query .= $this->EntityConfiguration->getTable();
		$query .= " SET ";
		foreach($this->EntityMapping as $key => $value) {
			$query .= $value["column"]." = :$key, ";
			$values[$key] = $this->$key;
		}
		$query = rtrim($query, ", ");
		$query .= " WHERE ";
		$query .= $this->EntityConfiguration->getIdColumn();
		$query .= " = :id";
		
		$this->execute($query, $values);
	}
	
	/**
	 * exists
	 * 
	 * TODO
	 */
	private function exists() {
		return $this->id != null;	
	}

	/**
	 * execute
	 * 
	 * TODO
	 */
	private function execute($query, $values) {
		Logger::debug($query);
		Logger::debug("Values: ".print_r($values, true));

		$Database = new Database();
		$stmt = $Database->prepare($query);
		$stmt->execute($values);	
	}
}
?>