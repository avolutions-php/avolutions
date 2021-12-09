# Migration

* [Introduction](#introduction)
* [Create migration](#create-migration)
* [Run migrations](#run-migrations)
* [Operations](#operations)
  * [Create new table](#create-new-table)
  * [Add column to table](#add-column-to-table)
  * [Remove column from table](#remove-column-from-table)
  * [Add index to table](#add-index-to-table)
  * [Add foreign key constraint to table](#add-foreign-key-constraint-to-table)

## Introduction
To made changes to your database schema (add or remove tables/columns etc.) the AVOLUTIONS framework provides a bunch of methods.

These methods can be used to write migrations for your database. The framework will check for the current version of your database and execute changes if they are not added to the database schema already.

## Create migration

All `Migrations` need to be stored in `application/Database`. A `Migration` is a class (with the same name as the file) extending `AbstractMigration` located in `Application\Database` namespace.
It needs to implement a property called `version` and a method `migrate()`:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;

class CreateUserTable extends AbstractMigration {
  public int $version = '20190915143000';

  public function migrate()
  {

  }
}
```

The Easiest way to create a new `Migration` is to use the [`create-migration` command](command.md#create-migration).

All migrations in the `application/Database` directory will be executed in the order of the version, from low to high.
The version should be unique, best practice is to use the current datetime of the creation as integer, e.g. 20190915143000.

## Run migrations
By default, the migrations will not be executed automatically. If you want to execute the migrations automatically, you have to change the value of config `database/migrateOnAppStart` to true.
This is not recommended for production systems.

To execute migrations manually use the [`database-migrate` command](command.md#database-migrate).

To get a list of all already executed migrations you can have a look into the table `migrations` in your database or use the [`database-status` command](command.md#database-status). 

## Operations
### Create new table

To create a new table use `create()` method:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;

class CreateUserTable extends AbstractMigration {
  public int $version = 20190915143000;

  public function migrate()
  {
    $columns = array();
    // $name, $type, $length , $default, $null, $primaryKey, $autoIncrement
    $columns[] = new Column('UserID', ColumnType::INT, 255, null, Column::NOT_NULL, true, true);
    $columns[] = new Column('Firstname', ColumnType::VARCHAR, 255);
    $columns[] = new Column('Lastname', ColumnType::VARCHAR, 255);
    $this->table('user')->create($columns);
  }
}
```

### Add column to table

To add a new column to a table use `addColumn()` method:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;
use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;

class AddMailToUserTable extends AbstractMigration {
  public int $version = 20190915143100;

  public function migrate()
  {
    $this->table('user')->addColumn(new Column('Mail', ColumnType::VARCHAR, 255), 'UserID');
  }
}
```

### Remove column from table

To remove a column from a table use `removeColumn()` method:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;

class RemoveMailFromUserTable extends AbstractMigration {
  public int $version = 20190915143200;

  public function migrate()
  {
    $this->table('user')->removeColumn('Mail');
  }
}
```

### Add index to table

To add an index (index, unique, primary key) to a table use `addIndex()` method:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;

class AddUniqueIndexToUserTable extends AbstractMigration {
  public int $version = 20190915143300;

  public function migrate()
  {
    $this->table('user')->addIndex(Table::UNIQUE, array('Firstname', 'Lastname'), 'UniqueName');
  }
}
```

### Add foreign key constraint to table

To add a foreign key constraint to a table use `addForeignKeyConstraint()` method:
```php
namespace Application\Database;

use Avolutions\Database\AbstractMigration;

class AddForeignKeyToUserTable extends AbstractMigration {
  public int $version = 20190915143400;

  public function migrate()
  {
    $this->table('user')->addForeignKeyConstraint('UserID', 'user_role', 'UserID');
  }
}
```
