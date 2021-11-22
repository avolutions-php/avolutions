<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace Avolutions\Orm;

use Avolutions\Collection\CollectionInterface;
use Avolutions\Collection\CollectionTrait;
use Avolutions\Core\Application;
use Avolutions\Database\Database;
use Avolutions\Di\ContainerException;
use Avolutions\Logging\Logger;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

/**
 * EntityCollection class
 *
 * An EntityCollection contains all elements of a specific Entity.
 * It provides the methods for filtering and sorting these elements.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class EntityCollection implements CollectionInterface
{
    use CollectionTrait;

    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * Database instance.
     *
     * @var Database $Database
     */
    private Database $Database;

    /**
     * Logger instance.
     *
     * @var Logger $Logger
     */
    private Logger $Logger;

    /**
     * The name of the entity.
     *
     * @var string $entity
     */
    protected string $entity = '';

    /**
     * The configuration of the entity.
     *
     * @var EntityConfiguration $EntityConfiguration
     */
    private EntityConfiguration $EntityConfiguration;

    /**
     * The mapping of the entity.
     *
     * @var EntityMapping $EntityMapping
     */
    private EntityMapping $EntityMapping;

    /**
     * The limit clause for the query.
     *
     * @var string $limitClause
     */
    private string $limitClause = '';

    /**
     * The orderBy clause for the query.
     *
     * @var string $orderByClause
     */
    private string $orderByClause = '';

    /**
     * The where clause for the query.
     *
     * @var string $whereClause
     */
    private string $whereClause = '';

    /**
     * __construct
     *
     * Creates a new EntityCollection for the given Entity type and loads the corresponding
     * EntityConfiguration and EntityMapping.
     *
     * @param Application $Application Application instance.
     * @param Database $Database Database instance.
     * @param Logger $Logger Logger instance.
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     */
    public function __construct(Application $Application, Database $Database, Logger $Logger, ?string $entity = null)
    {
        $this->Application = $Application;
        $this->Database = $Database;
        $this->Logger = $Logger;

        if (!is_null($entity)) {
            $this->entity = $entity;
        }

        $this->EntityConfiguration = $this->Application->make(
            EntityConfiguration::class,
            ['entity' => $this->entity]
        );
        $this->EntityMapping = $this->EntityConfiguration->getMapping();
    }

    /**
     * count
     *
     * Returns the number of items in the Collection.
     *
     * @return int The number of items in the Collection.
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function count(): int
    {
        $this->execute();

        return count($this->items);
    }

    /**
     * execute
     *
     * Executes the previously created database query and loads the Entities from
     * the database to the Entities property.
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    private function execute()
    {
        $query = 'SELECT ';
        $query .= $this->EntityConfiguration->getFieldQuery();
        $query .= ' FROM ';
        $query .= '`' . $this->EntityConfiguration->getTable() . '`';
        $query .= $this->getJoinStatement();
        $query .= $this->getWhereClause();
        $query .= $this->getOrderByClause();
        $query .= $this->getLimitClause();

        $stmt = $this->Database->prepare($query);

        $this->Logger->debug($query);

        $stmt->execute();

        while ($row = $stmt->fetch($this->Database::FETCH_ASSOC)) {
            $entityValues = [];

            foreach ($row as $columnKey => $columnValue) {
                $explodedKey = explode('.', $columnKey);
                $entityName = $explodedKey[0];
                $columnName = $explodedKey[1];

                if ($entityName == $this->entity) {
                    $entityValues[$columnName] = $columnValue;
                } else {
                    $entityValues[$entityName][$columnName] = $columnValue;
                }
            }

            $fullEntityName = $this->Application->getModelNamespace() . $this->entity;
            $Entity = $this->Application->make($fullEntityName, ['values' => $entityValues]);

            $this->items[] = $Entity;
        }
    }

    /**
     * limit
     *
     * Sets the number of records that should be loaded from the database.
     *
     * @param int $rowCount The number of records that should be loaded from the database.
     * @param int $offset Specifies the offset of the first row to return.
     *
     * @return EntityCollection $this
     */
    public function limit(int $rowCount, int $offset = 0): EntityCollection
    {
        $this->limitClause = $rowCount;
        if ($offset > 0) {
            $this->limitClause .= ' OFFSET ' . $offset;
        }

        return $this;
    }

    /**
     * getAll
     *
     * Returns all previously loaded Entities of the EntityCollection.
     *
     * @return array All previously loaded Entities.
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function getAll(): array
    {
        $this->execute();

        return $this->items;
    }

    /**
     * getById
     *
     * Returns the matching Entity for the given id.
     *
     * @param int $id The identifier of the Entity.
     *
     * @return Entity The matching Entity for the given id.
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function getById(int $id): Entity
    {
        $this->where($this->EntityConfiguration->getIdColumn() . ' = ' . $id);
        $this->execute();

        return $this->items[0];
    }

    /**
     * getFirst
     *
     * Returns the first Entity of the EntityCollection.
     *
     * @return Entity|null The first Entity of the EntityCollection.
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function getFirst(): ?Entity
    {
        $this->limit(1)->execute();

        return $this->items[0] ?? null;
    }

    /**
     * getJoinStatement
     *
     * Returns a join statement if the Entity has a joined Entity defined in the EntityMapping.
     *
     * @return string The join statement
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     */
    private function getJoinStatement(): string
    {
        $joinStmt = '';

        // Check all properties from the EntityMapping
        foreach ($this->EntityMapping as $value) {
            // If the property is of type Entity
            if ($value['isEntity']) {
                // Load the configuration of the linked Entity
                $EntityConfiguration = $this->Application->make(
                    EntityConfiguration::class,
                    ['entity' => $value['type']]
                );

                // Create the JOIN statement:
                // " JOIN {JoinedTable} ON {Table}.{Column} = {JoinedTable}.{JoinedColumn}"
                $joinStmt .= ' JOIN ';
                $joinStmt .= '`' . $EntityConfiguration->getTable() . '`';
                $joinStmt .= ' ON ';
                $joinStmt .= $this->EntityConfiguration->getTable() . '.' . $value['column'];
                $joinStmt .= ' = ';
                $joinStmt .= $EntityConfiguration->getTable() . '.' . $EntityConfiguration->getIdColumn();
            }
        }

        return $joinStmt;
    }

    /**
     * getLast
     *
     * Returns the last Entity of the EntityCollection.
     *
     * @return Entity The last Entity of the EntityCollection.
     *
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function getLast(): Entity
    {
        $this->execute();

        return end($this->items);
    }

    /**
     * getLimitClause
     *
     * Returns the processed limit clause for the final query.
     *
     * @return string The processed limit clause.
     */
    private function getLimitClause(): string
    {
        if (strlen($this->limitClause) > 0) {
            return ' LIMIT ' . $this->limitClause;
        }

        return '';
    }

    /**
     * getOrderByClause
     *
     * Returns the processed orderBy clause for the final query.
     *
     * @return string The processed orderBy clause.
     */
    private function getOrderByClause(): string
    {
        if (strlen($this->orderByClause) > 0) {
            return ' ORDER BY ' . rtrim($this->orderByClause, ', ');
        }

        return '';
    }

    /**
     * getWhereClause
     *
     * Returns the processed where clause for the final query.
     *
     * @return string The processed where clause.
     */
    private function getWhereClause(): string
    {
        if (strlen($this->whereClause) > 0) {
            return ' WHERE ' . $this->whereClause;
        }

        return '';
    }

    /**
     * orderBy
     *
     * Sets the sorting of the records that should be loaded from the database.
     * Can be called multiple times to sort on multiple columns.
     *
     * @param string $field The name of the Entity property to sort by.
     * @param bool $descending Whether the sort order should be descending or not.
     *
     * @return EntityCollection $this
     */
    public function orderBy(string $field, bool $descending = false): EntityCollection
    {
        $this->orderByClause .= $this->EntityMapping->$field['column'];
        if ($descending) {
            $this->orderByClause .= ' DESC';
        }
        $this->orderByClause .= ', ';

        return $this;
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
    public function where(string $condition): EntityCollection
    {
        $this->whereClause .= $condition;

        return $this;
    }
}
