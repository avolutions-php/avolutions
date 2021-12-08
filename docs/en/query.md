# Queries

* [Introduction](#introduction)
* [Database connection](#database-connection)
* [Database queries](#database-queries)

## Introduction

The Database module provides some functions to connect to a MySQL database, execute queries and perform schema changes ([Migrations](migration.md)) on the database.

## Database connection

To connect to a (MySQL) database you have to configure your connection parameters.
Have a look to the `config/database.php` [Configuration](config.md) file.
There are four [Configuration](config.md) values to configure: `host`, `database`, `user`, `password`.

Connection to your database is established, as soon as a new instance of `Database` class is created.
You can either inject it to constructor or get from `Application`:
```php
...
public function __construct(Database $Database)
{
  // use $Database 
}
...
```
```php
...
$Database = application(Database::class);
...
```

## Database queries

To execute queries on your Database you can just use the `query()` method of the `Database` class:
```php
$stmt = $Database->query('SELECT * FROM user');
while ($row = $stmt->fetch()) {
  print $row['Firstname'];
}
```
Because the AVOLUTIONS `Database` class extends the PHP `PDO` class it is possible to use all methods from it, e.g. prepared statements, transactions...
