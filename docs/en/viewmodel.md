# ViewModels

* [Introduction](#introduction)
* [Examples](#examples)
  * [Use a dynamic ViewModel](#use-a-dynamic-viewmodel)
  * [Use a typed ViewModel](#use-a-typed-viewmodel)

## Introduction

A ViewModel is a class that provides data for the [View](view.md). It is created/filled by the [Controller](controller.md).
It is the connection between the application data and the presentation and is used to separate the [Model](model.md) (data) from the [View](view.md) (presentation) logic.

## Examples
### Use a dynamic ViewModel

```php
namespace Application\ViewModel;

use Avolutions\Controller\Controller;

class UserController extends Controller {

  public function showAction($id)
  {
    $ViewModel = new ViewModel();
    $ViewModel->username = 'Alex';

    return new View('user/display', $ViewModel);
  }
}
```

### Use a typed ViewModel

Edit the View form the second View example like this:
```html
&lt;html&gt;
  &lt;head&gt;
    &lt;title&gt;Show user&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
    Hello &lt;?php print $ViewModel-&gt;getName(); ?&gt;
  &lt;/body&gt;
&lt;/html>
```

Create a new ViewModel in application/ViewModel, e.g. UserViewModel:
```php
namespace Application\ViewModel;

use Avolutions\View\ViewModel;

class UserViewModel extends ViewModel {

  public $firstname;

  public $lastname;

  public function getName()
  {
    return $this->firstname.' '.$this->lastname;
  }
}
```
Edit the Controller of the dynamic ViewModel example like this:
```php
namespace Application\Controller;

use Avolutions\Controller\Controller;

class UserController extends Controller {

  public function showAction($id)
  {
    $ViewModel = new UserViewModel();
    $ViewModel->firstname = 'Alex';
    $ViewModel->lastname = 'Vogt';

    return new View('user/display', $ViewModel);
  }
}
```
This example will result in the following output:
```
Hello Alex Vogt
```
