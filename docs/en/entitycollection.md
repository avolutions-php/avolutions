# EntityCollection

* [Introduction](#introduction)
* [Create an EntityCollection](#create-an-entitycollection)
* [Get methods](#get-methods)
  * [Get Entity by ID](#get-entity-by-id)
  * [Get all Entities](#get-all-entities)
  * [Get first/last](#get-firstlast)
* [Sort & filter the result](#sort--filter-the-result)
  * [Order entities](#order-entities)
  * [Limit results](#limit-results)
  * [Filter entities](#filter-entities)
* [Other methods](#other-methods)
  * [Count entities](#count-entities)
  
  
## Introduction
As in the [Model/Entity](model.md) chapter mentioned, you need an `EntityCollection` to retrieve entities from the database.
You can search & filter data and limit the results without writing (My)SQL queries.

## Create an EntityCollection

You should create a `EntityCollection` for every `Entity`. EntityCollections should be stored in `application/model` directory and using `Application\Model` namespace.
All you need to do is to extend `EntityCollection` and define the property `$entity` with the name of your entity.
```php
namespace Application\Model;

use Avolutions\Orm\EntityCollection;

class UserCollection extends EntityCollection
{
    protected string $entity = 'User';
}
```
A `EntityCollection` defined this way, can be injected into constructor, e.g. of a `Controller`:
```php
namespace Application\Controller;

use Application\Model\UserCollection;
use Avolutions\Controller\Controller;

class TestController extends Controller
{
    private UserCollection $UserCollection;

    public function __construct(UserCollection $UserCollection)
    {
      $this->UserCollection = $UserCollection;
    }

    public function indexAction()
    {
      $User = $this->UserCollection->getById(1);
    }
}
```

It is also possible to use a dynamic (not typed) EntityCollection:
 ```php
$UserCollection = $this->application->make(EntityCollection::class, ['entity' => 'User']);
```

## Get methods
### Get Entity by ID

If you know the ID of your dataset you can use the `getById()` method.
This method returns exactly one `Entity` object or null if no dataset with the given ID can be found.
```php
$User = $UserCollection->getById(3);
```

### Get all Entities

If you want to get all entities you can use the `getAll()` method.
This can be combined with `limit()`, `orderBy()` and `where()`.
The method returns an array with all Entity objects found.
```php
$User = $UserCollection->getAll();
```

### Get first/last

If you want to get the first or last entity you can use the `getFirst()` or `getLast()` method.
This can be combined with `limit()`, `orderBy()` and `where()`.
The method returns exactly one Entity object or null if no dataset can be found.
```php
$User = $UserCollection->getFirst();
$User = $UserCollection->getLast();
```

## Sort & filter the result
### Order entities

If it is necessary to sort your results, you can use the `orderBy()` method. You only have to pass the name of the column to the method.
The default sort direction is ascending, see the example below for a descending sorting.
Most of the time it is more performant to sort/oder the `EntityCollection` than sorting the result array afterwards.
This can be combined with all `get` methods, e.g. `getAll()`, `getFirst()`, `getLast()`
```php
$User = $UserCollection->orderBy('lastname')->getFirst(); // sorts the result by lastname ascending
$User = $UserCollection->orderBy('lastname', true)->getLast(); // sorts the result by lastname descending
```

### Limit results

If you only want a specific count of results (e.g. for pagination) you can use the `limit()` method.
The method takes the count of results as first parameter and an offset as an optional second parameter.
This can be combined with all `get` methods, the `orderBy()` and the `where()` method.
```php
$Users = $UserCollection->limit(3)->getAll(); // returns the first 3 records
$Users = $UserCollection->limit(3, 1)->getAll(); // returns the 3 records, skipping the first found
```

### Filter entities

To filter the results in a more complex way, the `where()` method can be used.
It takes a sql where clause as parameter.
This can be combined with all `get` methods, the `orderBy()` and the `limit()` method.
> This method is under development. Be careful by using, it can lead to sql injections.
```php
$User = $UserCollection->where('Lastname LIKE \'F%\'')->getAll(); // returns all Users where the Lastname starts with a "F"
```

## Other methods
### Count entities

To count the number of entities in your (filtered/sorted) EntityCollection, the `count()` method can be used.
This can be combined with `limit()`, `orderBy()` and `where()`.
```php
$userCount = $UserCollection->where('Lastname LIKE \'F%\'')->count(); // returns the number of Users where the Lastname starts with a "F"
```
