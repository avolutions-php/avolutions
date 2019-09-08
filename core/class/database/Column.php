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

namespace core\database;

/**
 * Column class
 *
 * TODO 
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class Column
{
	/**
	 * @var string $name TOD
	 */
	private $name;
	
	/**
	 * @var string $type TOD
	 */
	private $type;
	
	/**
	 * @var string $length TOD
	 */
	private $length;
	
	/**
	 * @var string $default TOD
	 */
	private $default;
	
	/**
	 * @var string $null TOD
	 */
	private $null;
	
	/**
	 * @var string $primaryKey TOD
	 */
	private $primaryKey;
	
	/**
	 * @var string $autoIncrement TOD
	 */
	private $autoIncrement;
	
	const TINYINT = "TINYINT";
	const SMALLINT = "SMALLINT";
	const MEDIUMINT = "MEDIUMINT";
	const INT = "INT";
	const BIGINT = "BIGINT";
	const DECIMAL = "DECIMAL";
	const FLOAT = "FLOAT";
	const DOUBLE = "DOUBLE";
	const BIT = "BIT";
	const BOOLEAN = "BOOLEAN";
	
	const DATE = "DATE";
	const DATETIME = "DATETIME";
	const TIMESTAMP = "TIMESTAMP";
	const TIME = "TIME";
	const YEAR = "YEAR";
	
	const CHAR = "CHAR";
	const VARCHAR = "VARCHAR";
	
	const TINYTEXT = "TINYTEXT";
	const TEXT = "TEXT";
	const MEDIUMTEXT = "MEDIUMTEXT";
	const LONGTEXT = "LONGTEXT";
	
	const NULL = "NULL";
	const NOTNULL = "NOT NULL";
	
	const CURRENT_TIMESTAMP = "CURRENT_TIMESTAMP";
	
	/**
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct($name, $type, $length = null, $default = null, $null = Column::NOTNULL, $primaryKey = false, $autoIncrement = false) {
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
	 * TODO
	 */
	public function getPattern() {
		$pattern = "";			
		$pattern .= $this->getNamePattern();
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
	 * TODO
	 */
	private function getNamePattern() {
		return "`".$this->name."` ";
	}
		
	/**
	 * getTypePattern
	 * 
	 * TODO
	 */
	private function getTypePattern() {
		$typePattern = $this->type;
		
		if($this->length != null) {
			$typePattern .= "(".$this->length.")";
		}
			
		return $typePattern." ";
	}
		
		
	/**
	 * getNullPattern
	 * 
	 * TODO
	 */
	private function getNullPattern() {			
		return $this->null;
	}
		
	/**
	 * getDefaultPattern
	 * 
	 * TODO
	 */
	private function getDefaultPattern() {
		if($this->type == self::BOOLEAN) {
			$this->default = $this->default ? 'TRUE' : 'FALSE';
		}
		
		if($this->default != null) {			
			return " DEFAULT ".$this->default;
		}
	
		return "";
	}

	/**
	 * getPrimaryKeyPattern
	 * 
	 * TODO
	 */
	private function getPrimaryKeyPattern()	{
		if($this->primaryKey) {
			return " PRIMARY KEY";
		}

		return "";
	}

	/**
	 * getAutoIncrementPattern
	 * 
	 * TODO
	 */
	private function getAutoIncrementPattern() {
		if($this->autoIncrement) {
			return " AUTO_INCREMENT";
		}

		return "";
	}
}
?>