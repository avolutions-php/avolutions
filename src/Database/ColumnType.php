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
 * ColumnType class
 *
 * The ColumnType class contains constants which describes the type of the database column.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.1
 */
class ColumnType
{
    /**
     * A very small integer
     *
     * @var string TINYINT
     */
    const TINYINT = 'TINYINT';

    /**
     * A small integer
     *
     * @var string SMALLINT
     */
    const SMALLINT = 'SMALLINT';

    /**
     * A medium-sized integer
     *
     * @var string MEDIUMINT
     */
    const MEDIUMINT = 'MEDIUMINT';

    /**
     * A standard integer
     *
     * @var string INT
     */
    const INT = 'INT';

    /**
     * A large integer
     *
     * @var string BIGINT
     */
    const BIGINT = 'BIGINT';

    /**
     * A fixed-point number
     *
     * @var string DECIMAL
     */
    const DECIMAL = 'DECIMAL';

    /**
     * A single-precision floating point number
     *
     * @var string FLOAT
     */
    const FLOAT = 'FLOAT';

    /**
     * A double-precision floating point number
     *
     * @var string DOUBLE
     */
    const DOUBLE = 'DOUBLE';

    /**
     * A bit field
     *
     * @var string BIT
     */
    const BIT = 'BIT';

    /**
     * A boolean field
     *
     * @var string $name
     */
    const BOOLEAN = 'BOOLEAN';

    /**
     * A date value in YYYY-MM-DD format
     *
     * @var string DATE
     */
    const DATE = 'DATE';

    /**
     * A date and time value in YYYY-MM-DD hh:mm:ss format
     *
     * @var string DATETIME
     */
    const DATETIME = 'DATETIME';

    /**
     * A timestamp value in YYYY-MM-DD hh:mm:ss format
     *
     * @var string TIMESTAMP
     */
    const TIMESTAMP = 'TIMESTAMP';

    /**
     * A time value in hh:mm:ss format
     *
     * @var string TIME
     */
    const TIME = 'TIME';

    /**
     * A year value in YYYY or YY format
     *
     * @var string YEAR
     */
    const YEAR = 'YEAR';

    /**
     * A fixed-length non-binary (character) string
     *
     * @var string CHAR
     */
    const CHAR = 'CHAR';

    /**
     * A variable-length non-binary string
     *
     * @var string VARCHAR
     */
    const VARCHAR = 'VARCHAR';

    /**
     * A fixed-length binary string
     *
     * @var string BINARY
     */
    const BINARY = 'BINARY';

    /**
     * A variable-length binary string
     *
     * @var string VARBINARY
     */
    const VARBINARY = 'VARBINARY';

    /**
     * A very small BLOB (binary large object)
     *
     * @var string TINYBLOB
     */
    const TINYBLOB = 'TINYBLOB';

    /**
     * A small BLOB
     *
     * @var string BLOB
     */
    const BLOB = 'BLOB';

    /**
     * A medium-sized BLOB
     *
     * @var string MEDIUMBLOB
     */
    const MEDIUMBLOB = 'MEDIUMBLOB';

    /**
     * A large BLOB
     *
     * @var string LONGBLOB
     */
    const LONGBLOB = 'LONGBLOB';

    /**
     * A very small non-binary string
     *
     * @var string TINYTEXT
     */
    const TINYTEXT = 'TINYTEXT';

    /**
     * A small non-binary string
     *
     * @var string TEXT
     */
    const TEXT = 'TEXT';

    /**
     * A medium-sized non-binary string
     *
     * @var string MEDIUMTEXT
     */
    const MEDIUMTEXT = 'MEDIUMTEXT';

    /**
     * A large non-binary string
     *
     * @var string LONGTEXT
     */
    const LONGTEXT = 'LONGTEXT';

    /**
     * An enumeration, each column value may be assigned one enumeration member
     *
     * @var string ENUM
     */
    const ENUM = 'ENUM';

    /**
     * A set, each column value may be assigned zero or more SET members
     *
     * @var string SET
     */
    const SET = 'SET';
}