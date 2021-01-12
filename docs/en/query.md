The Database module provides some functions to connect to a MySQL database, execute queries and perform schema changes ([Migrations](migration.md)) on the database.

#### Database connection

To connect to a (MySQL) database you have to configure your connection parameters.
Have a look to the *config/database.php* [Configuration](config.md) file.
There are four [Configuration](config.md) values to configure: *host*, *database*, *user*, *password*.
To create a new connection to the Database just call the constructor of the Database class:
```php
use Avolutions\Database\Database;

$Database = new Database();
```

#### Database queries

To execute queries on your Database you can just use the query() method of the Database class:
```php
use Avolutions\Database\Database;

$Database = new Database();
$stmt = $Database->query('SELECT * FROM user');
while ($row = $stmt->fetch()) {
  print $row['Firstname'];
}
```
Because the avolutions Database class extends the PHP PDO class it is possible to use all methods from it, e.g. prepared statements, transactions...
