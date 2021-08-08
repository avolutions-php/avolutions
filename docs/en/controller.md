# Controller

* [Introduction](#introduction)
* [Examples](#examples)
  * [Define an action that returns view by name convention](#define-an-action-that-returns-view-by-name-convention)
  * [Define an action that returns view by static name](#define-an-action-that-returns-view-by-static-name)
  * [Define an action that passing data to a view](#define-an-action-that-passing-data-to-a-view)

## Introduction
A Controller is a class that handles related request logic. Every controller can have a set of public methods, which are called Actions.

Controllers have to be stored into the *application/Controller* directory and defined in the *application\controller* namespace.
Every Controller must have Controller as a postfix for its file and class name. The Controller must also extend the base Controller class. 

The Easiest way to create a new `Controller` is to use the [`create-controller` command](command.md#create-controller).

Every Action must have Action as a postfix for its method name.

## Examples
### Define an action that returns view by name convention

Below is an example how to define a Controller with an Action that will return an <a href="/guide/view">View</a> by name conventions.
The Action will search for a View called *show.php* (= action name) in a directory called *application/View/user/* (= controller name).

```php
namespace Application\Controller;

use Avolutions\Controller\Controller;

class UserController extends Controller {

  public function showAction(int $id): View
  {
    return new View();
  }
}
```

### Define an action that returns view by static name

The following example will return a View by its full name (path and file name): *application/View/user/display.php*

```php
namespace Application\Controller;

use Avolutions\Controller\Controller;

class UserController extends Controller {

  public function showAction(int $id): View
  {
    return new View('user/display');
  }
}
```

### Define an action that passing data to a view

In the example below data (<a href="/guide/viewmodel">ViewModel</a>) is passed to the View.

```php
namespace Application\Controller;

use Avolutions\Controller\Controller;

class UserController extends Controller {

  public function showAction(int $id): View
  {
    $ViewModel = new ViewModel();
    $ViewModel->username = 'Alex';

    return new View('user/display', $ViewModel);
  }
}
```
