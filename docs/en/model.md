With the AVOLUTIONS ORM module is it possible to represent Database tables/rows as objects.

For every Entity a [Database](migration.md) table, a model and a Mapping is needed.

#### Model

The model is an object (class) which represents a Databse table where every column of the table is a property of the model.
All models are stored in the *application/Model* folder and have to inherit from the Entity class:
```php
namespace Application\Model;

use Avolutions\Orm\Entity;

class User extends Entity
{
  public $firstname;
  public $lastname;
}
```

#### Mapping

The mapping is the connection between the model and the database. Every Entity needs a mapping file stored in *application/Mapping*.
The file has to be named like the Model and the postfix *Mapping*, e.g. *application/Mapping/UserMapping.php*.

Only properties defined in the mapping file will be connected to database fields.
Therefore it is possible to have properties in the model which are not columns of the database table.
The mapping also provides the functionality to use different names in model (property) and table (column).

See the [Mapping chapter](mapping.md) to get a list of all available options for the Mapping file.

#### CRUD operations

With the AVOLUTIONS ORM module **C**reate, **R**ead, **U**pdate, **D**elete operations for entites can be perfomend.

##### Create/Update

Everytime properties of an Entity are changed the *save* method has to be called.
The save method detects if the Entity already exists or not and therefore update or create it.
```php
// create
$User = new User();
$User->firstname = 'Alex';
$User->lastname = 'Vogt';
$User->save();

// update
$User = EntityCollection('user')->getById(1);
$User->firstname = 'Alexander';
$User->save();
```

##### Delete

To delete an Entity just call the *delete* method:
```php
$User = EntityCollection('user')->getById(1);
$User->delete();
```

##### Read

To read/select an entity the [EntityCollection](entitycollection.md) is used.
Because of its complexity you can find a own chapter for it [here](entitycollection.md).
