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

return [
	'host' => getenv('DB_HOST') ?: '127.0.0.1',
	'database' => getenv('DB_DATABASE') ?: 'avolutions',
	'port' => getenv('DB_PORT') ?: '3306',
	'user' => getenv('DB_USER') ?: 'avolutions',
	'password' => getenv('DB_PASSWORD') ?: 'avolutions',
	'charset' => getenv('DB_CHARSET') ?: 'utf8',
	'migrateOnAppStart' => false
];
