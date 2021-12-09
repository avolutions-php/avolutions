# Model/Entity

* [Introduction](#introduction)
* [Model](#model)
* [Mapping](#mapping)
* [CRUD Operations](#crud-operations)
  * [Create/Update](#createupdate)
  * [Delete](#delete)
  * [Read](#read)

## Introduction

With the AVOLUTIONS ORM module is it possible to represent database tables/rows as objects.

For every `Entity` a [Database table](migration.md), a `Model` class and a [Mapping file](mapping.md) is needed.
We also recommend creating a typed [`EntityCollection`](entitycollection.md).

## Model

The model is an object (class) which represents a database table where every column of the table is a property of the model.
All models are stored in the `application/Model` directory, use `Application\Model` namespace and must extend `Avolutions\Orm\Entity`:
```php
namespace Application\Model;

use Avolutions\Orm\Entity;

class User extends Entity
{
  public string $firstname;
  public string $lastname;
}
```

The Easiest way to create a new `Model` is to use the [`create-model` command](command.md#create-model).

## Mapping

The mapping is the connection between the model and the database. Every Entity needs a mapping file stored in `application/Mapping`.
The file has to be named like the Model and the postfix `Mapping`, e.g. `application/Mapping/UserMapping.php`.

The Easiest way to create a new Mapping file is to use the [`create-mapping` command](command.md#create-mapping), or use the Option `-m` on `create-model` command.

Only properties defined in the mapping file will be connected to database fields.
Therefore, it is possible to have properties in the model which are not columns of the database table.
The mapping also provides the functionality to use different names in model (property) and table (column).

See the [Mapping chapter](mapping.md) to get a list of all available options for the Mapping file.

## CRUD operations

With the AVOLUTIONS ORM module **C**reate, **R**ead, **U**pdate, **D**elete operations for entities can be performed.

### Create/Update

Everytime properties of an Entity are changed the `save()` method has to be called.
The save method detects if the Entity already exists or not and therefore update or create it.
```php
// create
$User = new User();
$User->firstname = 'Alex';
$User->lastname = 'Vogt';
$User->save();

// update
$User = $UserCollection->getById(1);
$User->firstname = 'Alexander';
$User->save();
```

### Delete

To delete an Entity just call the `delete()` method:
```php
$User = $UserCollection->getById(1);
$User->delete();
```

### Read

To read/select an entity the [EntityCollection](entitycollection.md) is used.
Because of its complexity you can find an own chapter for it [here](entitycollection.md).
