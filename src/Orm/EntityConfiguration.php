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

use Avolutions\Core\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * EntityConfiguration class
 *
 * The EntityConfiguration class provides all configurations for an entity,
 * e.g. the mapping and the related database table name.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class EntityConfiguration
{
    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * The name of the entity.
     *
     * @var string $entity
     */
    private string $entity;

    /**
     * The name of the related database table.
     *
     * @var string $table
     */
    private string $table;

    /**
     * The name of the ID column in the database table.
     *
     * @var string $idColumn
     */
    private string $idColumn;

    /**
     * The mapping between the entity and the database table.
     *
     * @var EntityMapping $mapping
     */
    private EntityMapping $Mapping;

    /**
     * __construct
     *
     * Creates a new EntityConfiguration for the given Entity type and loads the corresponding
     * EntityMapping, table and id column.
     *
     * @param Application $Application Application instance.
     * @param string $entity The name of the Entity type.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(Application $Application, string $entity)
    {
        $this->Application = $Application;
        $this->entity = $entity;
        $this->loadMapping();
        $this->setTable();
        $this->setIdColumn();
    }

    /**
     * loadMapping
     *
     * Loads the EntityMapping for the given entity.
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    private function loadMapping()
    {
        $this->Mapping = $this->Application->make(EntityMapping::class, ['entity' => $this->entity]);
    }

    /**
     * getTable
     *
     * Returns the related database table of the entity.
     *
     * @return string $this->table
     */
    public function getTable(): string
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
    public function getIdColumn(): string
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
        $this->idColumn = $this->getTable() . 'ID';
    }

    /**
     * getMapping
     *
     * Returns the mapping between the entity and the database table.
     *
     * @return EntityMapping $this->idColumn
     */
    public function getMapping(): EntityMapping
    {
        return $this->Mapping;
    }

    /**
     * getFieldQuery
     *
     * Loads the fields from the EntityMapping and returns the field phrase for
     * the database query.
     *
     * @return string The field phrase for the database query.
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function getFieldQuery(): string
    {
        $fieldQuery = '';

        // Check all properties from the EntityMapping
        foreach ($this->Mapping as $property => $value) {
            // If the property is of type Entity
            if ($value['isEntity']) {
                // Load the configuration of the linked Entity
                $EntityConfiguration = $this->Application->make(
                    EntityConfiguration::class,
                    ['entity' => $value['type']]
                );

                // Get and add the field query for the linked Entity
                $fieldQuery .= $EntityConfiguration->getFieldQuery();
            } else {
                // Get the field query for the entity: " {Table}.{Column} AS `{Entity}.{property}`, "
                $fieldQuery .= $this->getTable() . '.' . $value['column'];
                $fieldQuery .= ' AS ';
                $fieldQuery .= '`' . $this->entity . '.' . $property . '`';
            }

            $fieldQuery .= ', ';
        }

        // Remove last comma from the query
        return rtrim($fieldQuery, ', ');
    }
}