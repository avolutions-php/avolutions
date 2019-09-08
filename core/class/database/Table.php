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
 * Table class
 *
 * TODO 
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class Table
{
	/**
	 * create
	 * 
	 * TODO
	 */
	public static function create($name, $Columns) {
		$query = "CREATE TABLE IF NOT EXISTS `".$name."` (";
				
		foreach($Columns as $Column) {
			$query .= $Column->getPattern().',';
		}
		$query = rtrim($query, ',');
		$query .= ")";
			
		$Database = new Database();
		$Database->query($query);
	}
}
?>