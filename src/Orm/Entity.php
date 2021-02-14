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

namespace Avolutions\Orm;

use Avolutions\Database\Database;
use Avolutions\Event\EntityEvent;
use Avolutions\Event\EventDispatcher;
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
	 * @var Entity $EntityBeforeChange The Entity after initializing
	 */
	private $EntityBeforeChange;

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
		$this->EntityConfiguration = new EntityConfiguration($this->getEntityName());
		$this->EntityMapping = $this->EntityConfiguration->getMapping();

        // Fill Entity attributes from values
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

        $this->EntityBeforeChange = clone $this;
	}

	/**
	 * save
	 *
	 * Saves the Entity object to the database. It will be either updated or inserted,
	 * depending on whether the Entity already exists or not.
	 */
    public function save()
    {
        EventDispatcher::dispatch(new EntityEvent('BeforeSave', $this));

		if ($this->exists()) {
            EventDispatcher::dispatch(new EntityEvent('BeforeUpdate', $this, $this->EntityBeforeChange));
            $this->update();
            EventDispatcher::dispatch(new EntityEvent('AfterUpdate', $this, $this->EntityBeforeChange));
		} else {
            EventDispatcher::dispatch(new EntityEvent('BeforeInsert', $this));
            $this->insert();
            EventDispatcher::dispatch(new EntityEvent('AfterInsert', $this));
        }

        EventDispatcher::dispatch(new EntityEvent('AfterSave', $this));
	}

	/**
	 * delete
	 *
	 * Deletes the Entity object from the database.
	 */
    public function delete()
    {
        EventDispatcher::dispatch(new EntityEvent('BeforeDelete', $this));

		$values = ['id' => $this->id];

		$query = 'DELETE FROM ';
		$query .= $this->EntityConfiguration->getTable();
		$query .= ' WHERE ';
		$query .= $this->EntityConfiguration->getIdColumn();
		$query .= ' = :id';

        $this->execute($query, $values);

        EventDispatcher::dispatch(new EntityEvent('AfterDelete', $this));
    }

    /**
	 * getEntityName
	 *
	 * Returns the shortname of the reflected class.
     *
     * @return string The name of the entity.
	 */
    public function getEntityName()
    {
		return (new \ReflectionClass($this))->getShortName();
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
    public function exists()
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