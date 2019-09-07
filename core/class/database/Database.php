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

use core\config;

/**
 * Database class
 *
 * TODO 
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class Database extends \PDO
{
	/**
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct() {
		$host	  = Config::get("database/host");
		$database = Config::get("database/database");
		$dsn 	  = "mysql:dbname=".$database.";host=".$host.";";
		$user     = Config::get("database/user");
		$password = Config::get("database/password");
		$charset  = Config::get("database/charset");
		$options  = array
		(
			\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$charset,
			\PDO::ATTR_PERSISTENT => true
		);	
		
		try {
			parent::__construct($dsn, $user, $password, $options);
		} catch (\PDOException $e) {
			print $e->getMessage();
		}	
	}
}
?>