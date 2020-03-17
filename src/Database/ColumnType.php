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

namespace Avolutions\Database;

/**
 * ColumnType class
 *
 * The ColumnType class contains constants which describes the type of the database column.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.1
 */
class ColumnType
{	
	/**
	 * @var string TINYINT A very small integer
	 */
    const TINYINT = 'TINYINT';    
    
	/**
	 * @var string SMALLINT A small integer
	 */
    const SMALLINT = 'SMALLINT';
    
	/**
	 * @var string MEDIUMINT A medium-sized integer
	 */
    const MEDIUMINT = 'MEDIUMINT';
    
	/**
	 * @var string INT A standard integer
	 */
    const INT = 'INT';
    
	/**
	 * @var string BIGINT A large integer
	 */
    const BIGINT = 'BIGINT';
    
	/**
	 * @var string DECIMAL A fixed-point number
	 */
    const DECIMAL = 'DECIMAL';
    
	/**
	 * @var string FLOAT A single-precision floating point number
	 */
    const FLOAT = 'FLOAT';
    
	/**
	 * @var string DOUBLE A double-precision floating point number
	 */
    const DOUBLE = 'DOUBLE';
    
	/**
	 * @var string BIT A bit field
	 */
    const BIT = 'BIT';
    
	/**
	 * @var string $name A boolean field
	 */
	const BOOLEAN = 'BOOLEAN';
	
	/**
	 * @var string DATE A date value in CCYY-MM-DD format
	 */
    const DATE = 'DATE';
    
	/**
	 * @var string DATETIME	A date and time value in CCYY-MM-DD hh:mm:ss format
	 */
    const DATETIME = 'DATETIME';
    
	/**
	 * @var string TIMESTAMP A timestamp value in CCYY-MM-DD hh:mm:ss format
	 */
    const TIMESTAMP = 'TIMESTAMP';
    
	/**
	 * @var string TIME	A time value in hh:mm:ss format
	 */
    const TIME = 'TIME';
    
	/**
	 * @var string YEAR A year value in CCYY or YY format
	 */
	const YEAR = 'YEAR';
	
	/**
	 * @var string CHAR A fixed-length nonbinary (character) string
	 */
    const CHAR = 'CHAR';
    
	/**
	 * @var string VARCHAR A variable-length non-binary string
	 */
	const VARCHAR = 'VARCHAR';
        
	/**
	 * @var string TINYTEXT A very small non-binary string
	 */
    const TINYTEXT = 'TINYTEXT';
    
	/**
	 * @var string TEXT A small non-binary string
	 */
    const TEXT = 'TEXT';
    
	/**
	 * @var string MEDIUMTEXT A medium-sized non-binary string
	 */
    const MEDIUMTEXT = 'MEDIUMTEXT';
    
	/**
	 * @var string LONGTEXT A large non-binary string
	 */
	const LONGTEXT = 'LONGTEXT';
}