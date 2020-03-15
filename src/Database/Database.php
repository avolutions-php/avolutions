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

namespace Avolutions\Database;

use Avolutions\Config\Config;

/**
 * Database class
 *
 * The Database class provides some functions to connect to a MySQL database, execute queries 
 * and perform schema changes (migrations) on the database. 
 *
 * @package		Database
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class Database extends \PDO
{
	/**
	 * __construct
	 * 
	 * Creates a database connection using the config values from database configuration file.
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
		
		parent::__construct($dsn, $user, $password, $options);			
	}
	
	
	/**
	 * migrate
	 * 
	 * Executes all migrations from the applications database directory.
	 */
	public static function migrate() {
		$migrationsToExecute = array();
		$migrationFiles = array_map('basename', glob(APP_DATABASE_PATH.'*.php'));
		
		$executedMigrations = self::getExecutedMigrations();
		
		foreach($migrationFiles as $migrationFile) {
			$migrationClassName = pathinfo($migrationFile, PATHINFO_FILENAME);
						
			require_once APP_DATABASE_PATH.$migrationFile;
 			$Migration = new $migrationClassName;
			
			if(!in_array($Migration->version, $executedMigrations)) {
				$migrationsToExecute[$Migration->version] = $Migration;
			}
		}
		
		ksort($migrationsToExecute);
		
		$Database = new Database();
		foreach ($migrationsToExecute as $version => $Migration) {
			$Migration->migrate();
			
			$stmt = $Database->prepare("INSERT INTO migration (Version, Name) VALUES (?, ?)");
			$stmt->execute(array($version, get_class($Migration)));
		}
	}
	
	/**
	 * getExecutedMigrations
	 * 
	 * Gets all executed migrations from the database and return the versions.
	 *
	 * @return array The version numbers of the executed migrations.
	 */
	private static function getExecutedMigrations() {
		$executedMigrations = array();
		
		$Database = new Database();
						
		$stmt = $Database->prepare("SELECT * FROM migration");
		$stmt->execute();		
		while ($row = $stmt->fetch(Database::FETCH_ASSOC)) {
			$executedMigrations[] = $row["Version"];
		}
		
		return $executedMigrations;
	}
}
?>