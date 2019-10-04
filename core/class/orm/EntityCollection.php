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
	 * @var string $entity The name of the entity.
	 */
	private $entity;
	
	/**
	 * @var string $EntityConfiguration The configuration of the entity.
	 */
	private $EntityConfiguration;
	
	/**
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct($entity) {
		print '__construct()';		
		
		$this->entity = $entity;
		
		$this->EntityConfiguration = new EntityConfiguration($this->entity);
		
		print_r($this);
	}	
		
	/**
	 * getAll
	 * 
	 * TODO
	 */
	public function getAll() {
		print 'getAll()';
	}
	
	/**
	 * getById
	 * 
	 * TODO
	 */
	public function getById($id) {
		$Database = new Database();
        	
		$query = "SELECT * FROM ".$this->EntityConfiguration->getTable()." WHERE ".$this->EntityConfiguration->getIdColumn()." = :id";
			
		$stmt = $Database->prepare($query);
		$stmt->bindParam(':id', $id);
				
		Logger::debug(str_replace(":id", $id, $stmt->queryString));  
		
		$stmt->execute();
		$Entity = new $this->entity();
		foreach($stmt->fetch(Database::FETCH_ASSOC) as $property => $value) {
			$property = lcfirst($property); // TODO 
			$Entity->$property = $value;
		}
		
		return $Entity;
	}
}
?>