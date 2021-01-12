To made changes to your database schema (add or remove tables/columns etc.) the AVOLUTIONS framework provides a bunch of methods.

These methods can be used to write migrations for your Database. The framework will check for the current version of your Database and execute changes if they are not added to the Database schema already.

By default the migrations will be executed automatically, if you do not want this you have to change the value of *database/migrateOnAppStart* to false.

To exectue the migrations by yourself use the following code:
```php
namespace Application\Database;

use Avolutions\Database\Database;

Database::migrate();
```

To create a new migration add a new file in *application/Database*, e.g. *CreateUserTable.php*. This file has to contain a class (with the same name as the file) which extends the *AbstractMigration*.
Therefore it needs a property *version* and a method *migrate()*:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;

class CreateUserTable extends AbstractMigration {
  public $version;

  public function migrate()
  {

  }
}
```
All migrations in the *application/Database* folder will be executed in the order of the version, from low to high.
The version should be unique, best practice is to use the current datetime of the creation as integer, e.g. 20190915143000.

#### Operations
##### Create new table

To create a new table use the method *create*:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\Table;

class CreateUserTable extends AbstractMigration {
  public $version = 20190915143000;

  public function migrate()
  {
    $columns = array();
    // $name, $type, $length , $default, $null, $primaryKey, $autoIncrement
    $columns[] = new Column('UserID', ColumnType::INT, 255, null, null, true, true);
    $columns[] = new Column('Firstname', ColumnType::VARCHAR, 255);
    $columns[] = new Column('Lastname', ColumnType::VARCHAR, 255);
    Table::create('user', $columns);
  }
}
```

##### Add column to table

To add a new column to a table use the method *addColumn*:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\Table;

class AddMailToUserTable extends AbstractMigration {
  public $version = 20190915143100;

  public function migrate()
  {
    Table::addColumn('user', new Column('Mail', ColumnType::VARCHAR, 255), 'UserID');
  }
}
```

##### Remove column from table

To remove a column from a table use the method *removeColumn*:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\Table;

class RemoveMailFromUserTable extends AbstractMigration {
  public $version = 20190915143200;

  public function migrate()
  {
    Table::removeColumn('user', 'Mail');
  }
}
```

##### Add index to table

To add an index (index, unique, primary key) to a table use the method *addIndex*:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\Table;

class AddUniqueIndexToUserTable extends AbstractMigration {
  public $version = 20190915143300;

  public function migrate()
  {
    Table::addIndex('user', Table::UNIQUE, array('Firstname', 'Lastname'), 'UniqueName');
  }
}
```

##### Add foreign key constraint to table

To add an foreign key constraint to a table use the method *addForeignKeyConstraint*:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;
use Avolutions\Database\Table;

class AddForeignKeyToUserTable extends AbstractMigration {
  public $version = 20190915143400;

  public function migrate()
  {
    Table::addForeignKeyConstraint('user', 'UserID', 'user_role', 'UserID');
  }
}
```
