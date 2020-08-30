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

use Avolutions\Config\Config;

/**
 * Database class
 *
 * The Database class provides some functions to connect to a MySQL database, execute queries 
 * and perform schema changes (migrations) on the database. 
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Database extends \PDO
{
	/**
	 * __construct
	 * 
	 * Creates a database connection using the config values from database configuration file.
	 */
    public function __construct()
    {
		$host = Config::get('database/host');
		$database = Config::get('database/database');
		$port = Config::get('database/port');
		$user = Config::get('database/user');
		$password = Config::get('database/password');
		$charset  = Config::get('database/charset');
		$options  = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$charset,
			\PDO::ATTR_PERSISTENT => true
        ];
        
		$dsn = 'mysql:dbname='.$database.';host='.$host.';port='.$port.'';
		
		parent::__construct($dsn, $user, $password, $options);			
    }
		
	/**
	 * migrate
	 * 
	 * Executes all migrations from the applications database directory.
     * 
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
	 */
    public static function migrate()
    {
		$migrationsToExecute = [];
		$migrationFiles = array_map('basename', glob(APP_DATABASE_PATH.'*.php'));
		
		$executedMigrations = self::getExecutedMigrations();
		
		foreach ($migrationFiles as $migrationFile) {
			$migrationClassName = APP_DATABASE_NAMESPACE.pathinfo($migrationFile, PATHINFO_FILENAME);
						
            $Migration = new $migrationClassName;
             
            // only use Migration extending the AbstractMigration
            if (!$Migration instanceof AbstractMigration) {
                throw new \RuntimeException('Migration "'.$migrationClassName.'" has to extend AbstractMigration');
            }
            
            // version has to be an integer use
            if (!is_int($Migration->version)) {
                throw new \InvalidArgumentException('The version of the migration "'.$migrationClassName.'" has to be an integer.');
            }
            
            // only exectue Migration if not already executed
			if (!in_array($Migration->version, $executedMigrations)) {
				$migrationsToExecute[$Migration->version] = $Migration;
			}
		}
		
		ksort($migrationsToExecute);
		
		$Database = new Database();
		foreach ($migrationsToExecute as $version => $Migration) {
			$Migration->migrate();
			
			$stmt = $Database->prepare('INSERT INTO migration (Version, Name) VALUES (?, ?)');
			$stmt->execute([$version, (new \ReflectionClass($Migration))->getShortName()]);
		}
	}
	
	/**
	 * getExecutedMigrations
	 * 
	 * Gets all executed migrations from the database and return the versions.
	 *
	 * @return array The version numbers of the executed migrations.
	 */
    private static function getExecutedMigrations()
    {
		$executedMigrations = [];
		
		$Database = new Database();
						
		$stmt = $Database->prepare('SELECT * FROM migration');
		$stmt->execute();		
		while ($row = $stmt->fetch(Database::FETCH_ASSOC)) {
			$executedMigrations[] = $row['Version'];
		}
		
		return $executedMigrations;
	}
}