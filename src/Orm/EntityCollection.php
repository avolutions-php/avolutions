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
 
namespace Avolutions\Orm;

use Avolutions\Core\CollectionInterface;
use Avolutions\Database\Database;
use Avolutions\Logging\Logger;

/**
 * EntityCollection class
 *
 * An EntityCollection contains all elements of a specific Entity. 
 * It provides the methods for filtering and sorting these elements.
 *
 * @package		ORM
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
	 * @var string $EntityMapping The mapping of the entity.
	 */
	private $EntityMapping;

	/**
	 * @var string $fieldQuery The field phrase for the query.
	 */
	private $fieldQuery;

	/**
	 * @var string $limitClause The limit clause for the query.
	 */
	private $limitClause;

	/**
	 * @var string $orderByClause The orderBy clause for the query.
	 */
	private $orderByClause;

	/**
	 * @var string $whereClause The where clause for the query.
	 */
	private $whereClause;
	
	/**
	 * __construct
	 * 
	 * Creates a new EntityCollection for the given Entity type and loads the corresponding 
	 * EntityConfiguration and EntityMapping.
	 * 
	 * @param string $entity The name of the Entity type.
	 */
	public function __construct($entity) {
		$this->entity = $entity;
		
		$this->EntityConfiguration = new EntityConfiguration($this->entity);
		$this->EntityMapping = $this->EntityConfiguration->getMapping();

		$this->setFieldQuery();
	}	

	/**
	 * execute
	 * 
	 * Executes the previously created database query and loads the Entites from
	 * the database to the Entities property.
	 */
	private function execute() {
		$Database = new Database();

		$query = "SELECT ";
		$query .= $this->fieldQuery;
		$query .= " FROM ";
		$query .= "`".$this->EntityConfiguration->getTable()."`";
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
	 * Sets the number of records that should be loaded from the database.
	 * 
	 * @param integer $rowCount The number of records that should be loaded from the database.
	 * @param integer $offset Specifies the offset of the first row to return.
	 * 
	 * @return EntityCollection $this
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
	 * Returns all previously loaded Entities of the EntityCollection.
	 * 
	 * @return array All previously loaded Entities.
	 */
	public function getAll() {
		$this->execute();

		return $this->Entities;
	}
	
	/**
	 * getById
	 * 
	 * Returns the matching Entity for the given id.
	 * 
	 * @param integer $id The identifier of the Entity.
	 * 
	 * @return Entity The matching Entity for the given id.
	 */
	public function getById($id) {
		$this->where($this->EntityConfiguration->getIdColumn()." = ".$id);
		$this->execute();

		return $this->Entities[0];
	}

	/**
	 * getFirst
	 * 
	 * Returns the first Entity of the EntityCollection.
	 * 
	 * @return Entity The first Entity of the EntityCollection.
	 */
	public function getFirst() {
		$this->limit(1)->execute();

		return $this->Entities[0];
	}

	/**
	 * getLast
	 * 
	* Returns the last Entity of the EntityCollection.
	 * 
	 * @return Entity The last Entity of the EntityCollection.
	 */
	public function getLast() {
		$this->execute();

		return end($this->Entities);
	}

	/**
	 * getLimitClause
	 * 
	 * Returns the processed limit clause for the final query. 
	 * 
	 * @return string The processed limit clause.
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
	 * Returns the processed orderBy clause for the final query. 
	 * 
	 * @return string The processed orderBy clause.
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
	 * Returns the processed where clause for the final query. 
	 * 
	 * @return string The processed where clause.
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
	 * Sets the sorting of the records that should be loaded from the database.
	 * Can be called multiple times to sort on multiple columns.
	 * 
	 * @param string $field The name of the Entity property to sort by.
	 * @param boolean $descending Whether the sort order should be descending or not.
	 * 
	 * @return EntityCollection $this
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
	 * setFieldQuery
	 * 
	 * Loads the fields from the EntityMapping and generates the field phrase for
	 * the database query.
	 */
	private function setFieldQuery() {
		$fieldQuery = "";

		foreach($this->EntityMapping as $key => $value) {
			$fieldQuery .= $value["column"].' AS '.$key.', ';
		}

		$this->fieldQuery = rtrim($fieldQuery, ", ");
	}

	/**
	 * where
	 * 
	 * Filters the EntityCollection by the given condition.
	 * 
	 * @param string $condition The filter condition.
	 * 
	 * @return EntityCollection $this
	 */
	public function where($condition) {
		$this->whereClause .= $condition;

		return $this;
	}
}
?>