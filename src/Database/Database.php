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

use PDO;

/**
 * Database class
 *
 * The Database class provides some functions to connect to a MySQL database, execute queries
 * and perform schema changes (migrations) on the database.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class Database extends PDO
{
    /**
     * __construct
     *
     * Creates a database connection using the config values from database configuration file.
     *
     * @param string $host Hostname of the database.
     * @param string $database Database name.
     * @param string $port Database port.
     * @param string $user User to connect to database with.
     * @param string $password Password for database user.
     * @param array $options Array of driver specific connection options.
     */
    public function __construct(
        string $host,
        string $database,
        string $port,
        string $user,
        string $password,
        array $options = []
    ) {
        $dsn = 'mysql:dbname=' . $database . ';host=' . $host . ';port=' . $port . '';

        parent::__construct($dsn, $user, $password, $options);
    }
}