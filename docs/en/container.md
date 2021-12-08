# Dependency Injection

* [Introduction](#introduction)
* [Auto wiring](#auto-wiring)
* [Resolving](#resolving)
* [Manually resolving entries](#manually-resolving-entries)
  * [get()](#get)
  * [make()](#make)
  * [Application helper](#application-helper)
* [Configuration](#configuration)
  * [Parameters](#parameters)
  * [Interfaces](#interfaces)
  * [Aliases](#aliases)

## Introduction
AVOLUTIONS provides a container to manage class dependencies and perform dependency injection.
Dependency injection is a technique where an object receives all its dependencies automatically by constructor parameters.

See the following example:
```php
<?php

namespace Application\Controller;

use Application\Model\UserCollection;
use Avolutions\Controller\Controller;

class UserController extends Controller
{
    private UserCollection $UserCollection;

    public function __construct(UserCollection $UserCollection)
    {
        $this->UserCollection = $UserCollection;
    }

    public function getUserAction(int $id)
    {
        return $this->UserCollection->getById($id);
    }
}
```

In this example, `getUserAction()` needs a `UserCollection` to return a user.
Therefore `UserCollectoin` is a dependency of `UserController`. 

## Auto wiring

The easiest way of dependency injection is auto wiring. 
This simply means, that all dependencies are injected automatically to a class.
AVOLUTIONS will use reflection to detect which parameters a constructor need.

All parameters must be typed to use auto wiring. Only instantiable types can be auto wired.

For the example above, AVOLUTIONS will create a new instance of `UserCollection` (if not already resolved) and pass it to the constructor of `UserController`.

## Resolving

By default, AVOLUTIONS will resolve all dependencies in the following application classes:
* `Command`
* `Controller`
* `EntityCollection`
* `Event`
* `Listener`
* `Migration`
* `Validator`

All dependencies will be resolved only ones by the `Container`.
Therefore, they act something like a singleton.

## Manually resolving entries

If you want to create a new instance of a class including it dependencies, you need to resolve it from `Contrainer`.
There are two methods to use for it `get()` and `make()`.

### get()

To get an instance of a class from the `Container` you can simply use `get()` method.
This method will resolve the entry if not already resolved and return it.

Let's say we have the following class:
```php
namespace Application\Service;

use Application\Model\UserCollection;

class UserService
{
    private UserCollection $UserCollection;

    public function __construct(UserCollection $UserCollection)
    {
        $this->UserCollection = $UserCollection;
    }
}
```

To get a new instance of this class you can use the `get()` method:
```php
use Application\Service\UserService;

$UserService = $Container->get(UserService::class);
```

Without any [configuration](#configuration), a `UserCollection` instance is created and passed to the constructor. 
The equivalent manual way to achieve this would be:
```php
use Application\Model\UserCollection;
use Application\Service\UserService;

$UserCollection = new UserCollection();
$UserService = new UserService($UserCollection);
```

`get()` will resolve `UserService` only once, this means it will behave like a singleton.

### make()

If you need to resolve the entry every time you should use `make()`.
Also, additional parameters can be passed to the constructor if using `make()`.

Let's say we have the following class:
```php
namespace Application\Service;

use Application\Model\UserCollection;

class UserService
{
    private UserCollection $UserCollection;
    private int $id;

    public function __construct(UserCollection $UserCollection, int $id)
    {
        $this->UserCollection = $UserCollection;
        $this->id = $id;
    }
}
```

To get a new instance of this class you can use the `make()` method and pass a value for parameter `$id`:
```php
use Application\Service\UserService;

$UserService = $Container->make(UserService::class, ['id' => 4711]);
```

The equivalent manual way to achieve this would be:
```php
use Application\Model\UserCollection;
use Application\Service\UserService;

$UserCollection = new UserCollection();
$UserService = new UserService($UserCollection, 4711);
```

### Application helper

The AVOLUTIONS [application class](application.md) extends `Container` and can therefore be used to `get` or `make` new instances.
You can either inject an `Application` instance into your class:
```php
...
public function __construct(Application $Application)
{
    $UserService = $Application->get(UserService::class);
}
...
```
Or simply use the [application helper](helper.md#application):
```php
$UserService = application(UserService::class);
```

## Configuration

AVOLUTIONS service container provides some configurations to control resolving of dependencies.
All configuration needs to be done after the `Container` or rather the `Application` instance was created.
E.g. in `bootstrap.php` if you use the [AVOLUTIONS application template](https://github.com/avolutions/app).

### Parameters

You can configure the `Container` to resolve a class with a fixed value for a constructor parameter.
E.g. if you want to use a config value, let's say we have the following class to connect to a database:
```php
class Database
{
    public function __construct(string $host, string $database, string $user, string $password) 
    {
        // connect to database with given parameter
    }
}
```
Now we want to pass the connection values as parameters, everytime a `Database` object is created/resolved by the `Container`.
To do so, we can configure the `Container` by using `set()` method. Pass class name and an array with default values, where array keys are the name of the constructor parameters:
```php
$Application->set(
    Database::class,
    [
        'host' => '127.0.01',
        'database' => 'avolutions',
        'user' => 'avolutions',
        'password' => 'top$ecret'
    ]
);
```
With `Container` configured like this, the `Database` object will be created using the configured values.
This can of course also be used to pass config values to the constructor of a class:
```php
$Application->set(
    Database::class,
    [
        'host' => config('database/host'),
        'database' => config('database/database'),
        'user' => config('database/user'),
        'password' => config('database/password')
    ]
);
```

### Interfaces

If you have an interface as a dependency, you need to tell the `Container` which implementation of this interface should be injected.
Let's say we have a class, needing a `Logger` implementing `LoggerInterface`:
```php
class Test
{
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger) 
    {
        $this->logger = $logger;
    }
}
```
And our `Logger` looks like this:
```php
class Logger implements LoggerInterface
{
    // ...
}
```
Then we need to tell the `Container`, by using `set()` method, to use our `Logger` class everytime a dependency of type `LoggerInterface` is needed:
```php
$Application->set(LoggerInterface::class, Logger::class);
```

### Aliases

An alias is some kind of shortcut you can configure for a class to not have to provide the full qualified class name every time.
It can also be helpful if the name of a class change during the lifetime of a project. This way you only need to change the alias definition.
To define an alias, the `set()` method of `Container` is used. Just provide you alias as a string and the full qualified class name:
```php
$Application->set('db', Database::class);
```
Now you can use retrieve `Database` by just using its alias 'db':
```php
$Database = $Application->get('db');
```