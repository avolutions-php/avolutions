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

namespace Avolutions\Database;

/**
 * Column class
 *
 * The Column class represents the schema of a database table column.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class Column
{
    /**
     * The name of the column.
     *
     * @var string $name
     */
    private string $name;

    /**
     * The data type of the column.
     *
     * @var string $type
     */
    private string $type;

    /**
     * The length of the column.
     *
     * @var string|null $length
     */
    private ?string $length;

    /**
     * The default value of the column.
     *
     * @var string|null $default
     */
    private ?string $default;

    /**
     * A flag if the column can be null or not.
     *
     * @var string $null
     */
    private string $null;

    /**
     * A flag if the column is a primary key or not.
     *
     * @var bool $primaryKey
     */
    private bool $primaryKey;

    /**
     * A flag if the column is an auto increment column or not.
     *
     * @var bool $autoIncrement
     */
    private bool $autoIncrement;

    /**
     * A constant for the string "NULL"
     *
     * @var string NULL
     */
    const NULL = 'NULL';

    /**
     * A constant for the string "NOT NULL"
     *
     * @var string NOT_NULL
     */
    const NOT_NULL = 'NOT NULL';

    /**
     * A constant for the string "CURRENT_TIMESTAMP"
     *
     * @var string CURRENT_TIMESTAMP
     */
    const CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';

    /**
     * __construct
     *
     * Creates a new Column object.
     *
     * @param string $name The name of the column.
     * @param string $type The data type of the column.
     * @param string|null $length The length of the column.
     * @param string|null $default The default value of the column.
     * @param string $null A flag if the column can be null or not.
     * @param bool $primaryKey A flag if the column is a primary key or not.
     * @param bool $autoIncrement A flag if the column is an auto increment column or not.
     */
    public function __construct(
        string $name,
        string $type,
        ?string $length = null,
        ?string $default = null,
        string $null = Column::NOT_NULL,
        bool $primaryKey = false,
        bool $autoIncrement = false
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->length = $length;
        $this->default = $default;
        $this->null = $null;
        $this->primaryKey = $primaryKey;
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * getPattern
     *
     * Returns the SQL pattern for the column.
     *
     * @return string The SQL pattern for the column.
     */
    public function getPattern(): string
    {
        $pattern = $this->getNamePattern();
        $pattern .= $this->getTypePattern();
        $pattern .= $this->getNullPattern();
        $pattern .= $this->getDefaultPattern();
        $pattern .= $this->getPrimaryKeyPattern();
        $pattern .= $this->getAutoIncrementPattern();

        return $pattern;
    }

    /**
     * getNamePattern
     *
     * Returns the SQL pattern for the name attribute.
     *
     * @return string The SQL pattern for the name attribute.
     */
    private function getNamePattern(): string
    {
        return '`' . $this->name . '` ';
    }

    /**
     * getTypePattern
     *
     * Returns the SQL pattern for the type attribute.
     *
     * @return string The SQL pattern for the type attribute.
     */
    private function getTypePattern(): string
    {
        $typePattern = $this->type;

        if ($this->length != null) {
            $typePattern .= '(' . $this->length . ')';
        }

        return $typePattern . ' ';
    }


    /**
     * getNullPattern
     *
     * Returns the SQL pattern for the null attribute.
     *
     * @return string The SQL pattern for the null attribute.
     */
    private function getNullPattern(): string
    {
        return $this->null;
    }

    /**
     * getDefaultPattern
     *
     * Returns the SQL pattern for the default attribute.
     *
     * @return string The SQL pattern for the default attribute.
     */
    private function getDefaultPattern(): string
    {
        if ($this->type == ColumnType::BOOLEAN) {
            $this->default = $this->default ? 'TRUE' : 'FALSE';
        }

        if ($this->default != null) {
            return ' DEFAULT ' . $this->default;
        }

        return '';
    }

    /**
     * getPrimaryKeyPattern
     *
     * Returns the SQL pattern for the primary key attribute.
     *
     * @return string The SQL pattern for the primary key attribute.
     */
    private function getPrimaryKeyPattern(): string
    {
        if ($this->primaryKey) {
            return ' PRIMARY KEY';
        }

        return '';
    }

    /**
     * getAutoIncrementPattern
     *
     * Returns the SQL pattern for the auto increment attribute.
     *
     * @return string The SQL pattern for the auto increment attribute.
     */
    private function getAutoIncrementPattern(): string
    {
        if ($this->autoIncrement) {
            return ' AUTO_INCREMENT';
        }

        return '';
    }
}