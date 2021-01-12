
As in the [Model/Entity](model.md) chapter mentioned, you can use the EntityCollection to retrieve Entities from the database.
You can search & filter data and limit the reults without writing (My)SQL queries.

##### Create an EntityCollection

To create a collcetion for an Entity you just have to create a new instance of *EntityCollection* and pass the name of the Entity to the constructor:
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
```

##### Get methods
###### Get Entity by ID

If you know the ID of your dataset you can use the *getById* method.
This method returns exactly one Entity object or null if no dataset with the given ID can be found.
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
$User = $UserCollection->getById(3);
```

###### Get all Entities

If you want to get all Entites you can use the *getAll* method.
This can be combined with *limit*, *orderBy* and *where*.
The methods returns an array with all Entity objects found.
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
$User = $UserCollection->getAll();
```

###### Get first/last

If you want to get the first or last Entity you can use the *getFirst* or *getLast* method.
This can be combined with *limit*, *orderBy* and *where*.
The method returns exactly one Entity object or null if no dataset can be found.
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
$User = $UserCollection->getFirst();
$User = $UserCollection->getLast();
```

##### Sort & filter the result
###### Order entities

If it is necessary to sort your results, you can use the *orderBy* method. You only have to pass the name of the column to the method.
The default sort direction is ascending, see the example below for a descending sorting.
Most of the time it is more performant to sort in the EntityCollection than sorting the result array.
This can be combined with all *get* methods, e.g. *getAll*, *getFirst*, *getLast*
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
$User = $UserCollection->orderBy('lastname')->getFirst(); // sorts the result by lastname ascending
$User = $UserCollection->orderBy('lastname', true)->getLast(); // sorts the reusult by lastname descending
```

##### Limit results

If you only want a specific count of results (e.g. for pagination) you can use the *limit* method.
The method takes the count of results as first parameter and an offset as an optional second parameter.
This can be combined with all *get* methods, the *orderBy* and the *where* method.
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
$Users = $UserCollection->limit(3)->getAll(); // returns the first 3 records
$Users = $UserCollection->limit(3, 1)->getAll(); // returns the 3 records, skipping the first found
```

##### Filter entities

To filter the results in a more compley way, the *where* method can be used.
It takes a sql where clause as parameter.
This can be combined with all *get* methods, the *orderBy* and the *limit* method.
> This method is under development. Be careful by using, it can lead to sql injections.
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
$User = $UserCollection->where('Lastname LIKE \'F%\'')->getAll(); // returns all Users where the Lastname starts with a "F"
```

#### Other methods
##### Count entities

To count the number of Entities in your (filtered/sorted) EntityCollection, the *count* method can be used.
This can be combined with the *where*, *orderBy* and the *limit* method.
```php
use Avolutions\Orm\EntityCollection;

$UserCollection = new EntityCollection('user');
$userCount = $UserCollection->where('Lastname LIKE \'F%\'')->count(); // returns the number of Users where the Lastname starts with a "F"
```
