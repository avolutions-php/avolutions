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
 
namespace Avolutions\Orm;

use Avolutions\Database\Database;
use Avolutions\Logging\Logger;

/**
 * Entity class
 *
 * An entity represents a clearly identified object from an entity collection.
 * It provides the methods for manipulating the Entity with CRUD operations.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
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
	 * @var string $EntityMapping The mapping of the entity.
	 */
	private $EntityMapping;
			
	/**
	 * __construct
	 * 
	 * Creates a new Entity object and loads the corresponding EntityConfiguration
	 * and EntityMapping.
     * 
     * @param array $values The Entity attributes as an array
	 */
    public function __construct($values = [])
    {
		$this->EntityConfiguration = new EntityConfiguration((new \ReflectionClass($this))->getShortName());
        $this->EntityMapping = $this->EntityConfiguration->getMapping();
        
        /**
         * Fill Entity attributes from values
         */
        if (!empty($values)) {            
            foreach ($this->EntityMapping as $key => $value) {
                if (isset($values[$key])) {
                     // If the property is of type Entity
                    if ($value['isEntity']) {
                        // Create a the linked Entity and pass the values
                        $entityName = APP_MODEL_NAMESPACE.$value['type'];
                        $this->$key = new $entityName($values[$key]);
                    } else {
                        $this->$key = $values[$key];
                    }
                }
            }
        }	
	}	
		
	/**
	 * save
	 * 
	 * Saves the Entity object to the database. It will be either updated or inserted,
	 * depending on whether the Entity already exists or not.
	 */
    public function save()
    {		
		if ($this->exists()) {
			$this->update();
		} else {
			$this->insert();
		}
	}	

	/**
	 * delete
	 * 
	 * Deletes the Entity object from the database.
	 */
    public function delete()
    {
		$values = ['id' => $this->id];	

		$query = 'DELETE FROM ';
		$query .= $this->EntityConfiguration->getTable();
		$query .= ' WHERE ';
		$query .= $this->EntityConfiguration->getIdColumn();
		$query .= ' = :id';

		$this->execute($query, $values);
	}	

	/**
	 * insert
	 * 
	 * Inserts the Entity object into the database.
	 */
    private function insert()
    {
		$values = [];
		$columns = [];
		$parameters = [];

		foreach ($this->EntityMapping as $key => $value) {         
            // Only for simple fields, no Entities   
            if (!$value['isEntity']) {
                $columns[] = $value['column'];
                $parameters[] = ':'.$key;
                $values[$key] = $this->$key;
            }
		}	

		$query = 'INSERT INTO ';
		$query .= $this->EntityConfiguration->getTable();
		$query .= ' (';
		$query .= implode(', ', $columns);	
		$query .= ') VALUES (';
		$query .= implode(', ', $parameters);	
		$query .= ')';
		
		$this->execute($query, $values);
	}	

	/**
	 * update
	 * 
	 * Updates the existing database entry for the Entity object.
	 */
    private function update()
    {
		$values = [];

		$query = 'UPDATE ';
		$query .= $this->EntityConfiguration->getTable();
		$query .= ' SET ';
		foreach ($this->EntityMapping as $key => $value) {            
            // Only for simple fields, no Entities   
            if (!$value['isEntity']) {
                $query .= $value['column'].' = :'.$key.', ';
                $values[$key] = $this->$key;
            }
		}
		$query = rtrim($query, ', ');
		$query .= ' WHERE ';
		$query .= $this->EntityConfiguration->getIdColumn();
		$query .= ' = :id';
		
		$this->execute($query, $values);
	}
	
	/**
	 * exists
	 * 
	 * Checks if the Entity already exists in the database.
	 * 
	 * @return bool Returns true if the entity exists in the database, false if not.
	 */
    private function exists()
    {
		return $this->id != null;	
	}

	/**
	 * execute
	 * 
	 * Executes the previously created database query with the provided values. 
	 * 
	 * @param string $query The query string that will be executed.
	 * @param array $values The values for the query.
	 */
    private function execute($query, $values)
    {
		Logger::debug($query);
		Logger::debug('Values: '.print_r($values, true));

		$Database = new Database();
		$stmt = $Database->prepare($query);
		$stmt->execute($values);	
	}
}