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

use Avolutions\Orm\EntityMapping;

/**
 * EntityConfiguration class
 *
 * The EntityConfiguration class provides all configurations for an entity, 
 * e.g. the mapping and the related database table name.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
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
    public function __construct($entity)
    {		
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
    private function loadMapping()
    {	
		$this->Mapping = new EntityMapping($this->entity);
	}
	
	/**
	 * getTable
	 * 
	 * Returns the related database table of the entity.
	 * 
	 * @return string $this->table
	 */
    public function getTable()
    {
		return $this->table;
	}
	
	/**
	 * setTable
	 * 
	 * Sets the name of the corresponding table for the entity.
	 */
    private function setTable()
    {	
		$this->table = strtolower($this->entity);
	}
	
	/**
	 * getIdColumn
	 * 
	 * Returns the name of the ID column in the database table.
	 * 
	 * @return string $this->idColumn
	 */
    public function getIdColumn()
    {
		return $this->idColumn;
	}
	
	/**
	 * setIdColumn
	 * 
	 * Sets the name of the ID column in the database table.
	 */
    private function setIdColumn()
    {	
		$this->idColumn = $this->getTable().'ID';
	}

	/**
	 * getMapping
	 * 
	 * Returns the mapping between the entity and the database table.
	 * 
	 * @return EntityMapping $this->idColumn
	 */
    public function getMapping()
    {	
		return $this->Mapping;
    }

	/**
	 * getFieldQuery
	 * 
	 * Loads the fields from the EntityMapping and generates the field phrase for
	 * the database query.
	 */
    public function getFieldQuery()
    {
		$fieldQuery = '';

		foreach ($this->Mapping as $key => $value) {
            if (isset($value['type']) && is_a(APP_MODEL_NAMESPACE.$value['type'], 'Avolutions\Orm\Entity', true)) {
                $EntityConfiguration = new EntityConfiguration($value['type']);
                $fieldQuery .= $EntityConfiguration->getFieldQuery();
            } else {
                $fieldQuery .= $this->getTable().'.'.$value['column'].' AS `'.$this->entity.'.'.$key.'`, ';
            }
        }

		return rtrim($fieldQuery, ', ');
	}
}