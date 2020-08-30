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

return [
	'host' => getenv('DB_HOST') ?: '127.0.0.1',
	'database' => getenv('DB_DATABASE') ?: 'avolutions',
	'port' => getenv('DB_PORT') ?: '3306',
	'user' => getenv('DB_USER') ?: 'avolutions',
	'password' => getenv('DB_PASSWORD') ?: 'avolutions',
	'charset' => 'utf8',
	'migrateOnAppStart' => false	
];
