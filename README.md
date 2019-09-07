<p align="center"><img src="http://avolutions.de/logo.png" width="200"></p>

# About AVOLUTIONS
AVOLUTIONS is just another open source PHP framework.  
Currently it provides default things like:
* Simple and fast [Routing](#routing) including [Controllers and Actions](#controllers-and-actions)
* [Views](#views)
* [ViewModels](#viewmodels)	
* [Configuration](#configuration)

**Current version**: 0.2.0-alpha released on 07.09.2019

This is just a hobby project but it is continuously being worked on.
## Roadmap
* Logging
* Session and Cookie handling
* Database driver and migration
* ORM
* ViewEngine
* ...

# Getting started

## Installation

### Download
Download the latest version at [Github](https://github.com/avolutions/avolutions/archive/master.zip) or [avolutions.de](http://framework.avolutions.de/download).
Unzip the downloaded package. 

### Document root
After unpacking you have to configure your web servers document root to the _public_ folder. The _index.php_ file will be the entry point for every HTTP request.

### Pretty URLs
There is a _.htaccess_ file in the _public_ folder that will redirect every URL to _index.php_. If you are using an _Apache_ web server, be sure to enable the _mod_rewrite_ module.

### Application directory
Create a new folder named _application_ in the root directory.

## Tutorial

### Routing
A route is the _mapping_ between the requested URL and the __Controller__ and __Action__ that will be called and executed.  
  
All __Routes__ for your application will be defined in __./routes.php__. The __Routes__ has to be added to the __RouteCollection__ via the __addRoute()__ method.  
  
A __Route__ object can have three parameters:  
1. The __URL__ that should be mapped  
```php
@param string $url The URL that will be mapped
```
2. The configuration for the __Controller__, __Action__ and HTTP-__Method__ as an associative array  
```php
@param array $defaults Default values for the Route
  $defaults = [
    'controller' => string Name of the controller
    'action'     => string Name of the action
    'method'     => string Name of the method (GET|POST)		
  ]	
```
3. The configuration for the __Parameters__ as an multidimensional associative array
```php
@param array $parameters An array which contains all parameters and their options 
  '{param}' = [  => string Name of the parameter
    'format'   => string RegEx for valid format
    'optional' => bool   If true the parameter is optional
    'default'  => string Default value for the parameter if it is optional
	]
```

#### Examples
##### Call a static __Controller__ and __Action__
```php
$RouteCollection->addRoute(new Route('/login',
  array(
    'controller' => 'auth',
    'action'	 => 'login'
  )
));
```
This __Route__ will call the __loginAction()__ method of the __AuthController__, every time someone request the URL _*http:*//yourapp/login_.

##### Call a dynamic __Controller__ and __Action__
```php
$RouteCollection->addRoute(new Route('/<controller>/<action>'));
```
This __Route__ uses the reserved keywords _<controller>_ and _<action>_. These keywords can be used to call __Controllers__ and __Actions__ based on the requested __URL__.  
For example: if a user requests the __URL__ _*http:*//yourapp/user/create_ the routing engine will call the __createAction()__ method of the __UserController__.

##### Call a __Route__ with __Parameter(s)__
```php
$RouteCollection->addRoute(new Route('/user/<id>',
  array(
    'controller' => 'user',
    'action'	 => 'show'
  ),
  array(
    'id' => array(
      'format'   => '[0-9]',
      'optional' => true,
      'default'  => 1
    )
  )
));
```
In this example the __Route__ contains a placeholder (inside the angle brackets) for a parameter ("id") in the __URL__. There can be a configuration for every parameter in the __URL__ (3rd parameter of the __Route__ object).
The configuration consists of three parts:
1. A regular expression to check the valid format of the parameter
2. A flag that indicates if the parameter is optional (true) or not (false = default)
3. A value which will be used if an optional parameter is not passed
In this example the following requests will lead to the this results:  

Request | Result
------------ | -------------
_*http:*//yourapp/user/15_ | __UserController->showAction($id)__ with $id = 15 will be called.
_*http:*//yourapp/user_ | __UserController->showAction($id)__ with $id = 1 will be called.
_*http:*//yourapp/user/abc_ | Will lead to an error.

### Controllers and Actions
A __Controller__ is a class that handles releated request logic. Every controller can have a set of methods, which are called __Actions__.  
  
__Controllers__ has to be stored into the _application/controller_ directory and defined in the _application\controller_ namespace. Every __Controller__ must have _Controller_ as a postfix for its file and class name. The __Controller__ must also extends the base __Controller__. Every __Action__ must have _Action_ as a postfix for its method name.  

#### Examples
##### Define an action that returns view by name convention
Below is an example how to define a __Controller__ with an __Action__ that will return an __View__ by name conventions, i.e. the __Action__ will search for a __View__ called _show.php_ (= action name) in an directory called _application/view/user/_ (= controller name).
```php
<?php	
  use core\Controller;
	
  class UserController extends Controller {
	
    public function showAction($id) {	
      return new View();
    }
  }
?>
```

##### Define an action that returns view by static name
The following example will return a __View__ by its full name (path and file name): _application/view/user/display.php_
```php
<?php	
  use core\Controller;
	
  class UserController extends Controller {
	
    public function showAction($id) {	
      return new View('user/display');
    }
  }
?>
```

##### Define an action that passing data to a view
In the example below data (__ViewModel__) is passed to the __View__. The explanation of how __Views__ and __ViewModels__ working together can be found in the following chapters.
```php
<?php
  use core\Controller;
	
  class UserController extends Controller {
	
    public function showAction($id) {	
      $ViewModel = new ViewModel();
      $ViewModel->username = 'Alex';
		
      return new View('user/display', $ViewModel);
    }
  }
?>
```

### Views
__Views__ are files that contains any representation of the application. This allows the separation from the application logic. __Views__ normally contains _HTML_, _CSS_ and _JavaScript_ and can also contain variable content that will be passed from the __Controller__ via __ViewModels__.  
  
Every __View__ file has to be stored into _application/view_ and its subdirectories.  
 
#### Examples
##### Create a simple view
To create a __View__ that will be returned by the first example above, just create a new file in _application/view/user/_ named _show.php_:
```php
<html>
  <head>
    <title>Show user</title>
  </head>
  <body>
    Hello world
  </body>
</html>
```
This example will result in the following output:
```
Hello world
```

##### Create a view with variable content
As mentioned above, __Views__ can also contains variable content, that will be filled with data from the __Controller__/__ViewModel__.
The following example shows how to display the data passed by the __ViewModel__ in the third __Controller__ exmaple:
```php
<html>
  <head>
    <title>Show user</title>
  </head>
  <body>
    Hello <?php print $ViewModel->username; ?>
  </body>
</html>
```
This example will result in the following output:
```
Hello Alex
```
 
### ViewModels
A __ViewModel__ is a class that provides data for the __View__. It is created/filled by the __Controller__/__Action__. It is the connection between the application data and the presentation and is used to separate the model (data) from the view (presentation) logic.  

#### Examples
##### Use a dynamic ViewModel
```php
<?php
  use core\Controller;
	
  class UserController extends Controller {
	
    public function showAction($id) {	
      $ViewModel = new ViewModel();
      $ViewModel->username = 'Alex';
		
      return new View('user/display', $ViewModel);
    }
  }
?>
```

##### Use a typed ViewModel
Edit the __View__ form the second __View__ example like this:
```php
<html>
  <head>
    <title>Show user</title>
  </head>
  <body>
    Hello <?php print $ViewModel->getName(); ?>
  </body>
</html>
```

Create a new __ViewModel__ in _application/viewmodel_, e.g. _UserViewModel_:
```php
<?php	
  use core\view\viewmodel;

  class UserViewModel extends ViewModel {

    public $firstname;

    public $lastname;

    public function getName() {
      return $this->firstname." ".$this->lastname;
    }
  }
?>
```

Edit the __Controller__ of the dynamic __ViewModel__ example like this:
```php
<?php
  use core\Controller;
	
  class UserController extends Controller {
	
    public function showAction($id) {	
      $ViewModel = new UserViewModel();
      $ViewModel->firstname = "Alex";
      $ViewModel->lastname = "Vogt";
		
      return new View('user/display', $ViewModel);
    }
  }
?>
```

This example will result in the following output:
```
Hello Alex Vogt
```

### Configuration
There are config files where you can store __Configuration__ values that are available everywhere in the application.  
The config values are not settable/editable at runtime.    

#### Examples
##### Add a new Configuration value 
To store a new __Configuration__ value add a new "config" file at _application/config_, e.g. _user.php_.
Just return an array with all your config values as _keys_:
```php
<?php
  return array(
    "showLastname" => true
  );
?>
```

##### Override an existing Configuration value
There are some core __Configuration__ values. These values are stored in the _config_ folder of the __AVOLUTIONS__ core:
  
Configuration key | default value | since
------------ | ------------- | -------------
- | - | -

You should never change a file inside the _core_ folder, otherwise there can be conflicts or data loss when updating the framework.
Therefore it is possible to overwrite the _core_ values with your _application_ values. Just create a config file inside the _application/config_ 
with the same name as the file in _core/config_. Use the same array key to overwrite the core __Configuration__ value.

##### Use the Configuration value in application
To use the __Configuration__ value you need to know the key. The key is composed of the _file_ name and the array keys.  
E.g. the key of the __Configuration__ value from our example above is: _user/showLastname_.
  
To use the __Configuration__ value in the application we will edit the _getName()_ method of our __ViewModel__ example like the following:
```php
<?php	
    use core\config;
	...
		public function getName() {
			if(Config::get("user/showLastname")) {
				return $this->firstname." ".$this->lastname;
			}
			
			return $this->firstname;
		}
	...
?> 
```
If the __Configuration__ value is set to _true_ it will result in the following output:
```
Hello Alex Vogt
```
If the __Configuration__ value is set to _false_ it will result in the following output:
```
Hello Alex
```

# License
The AVOLUTIONS framework is an open source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
