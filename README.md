<p align="center"><img src="http://avolutions.de/logo.png" width="200"></p>

# About AVOLUTIONS
AVOLUTIONS is just another open source PHP framework.  
Currently it provides default things like:
* Simple and fast [Routing](#routing)
* [Controllers and Actions](#controllers-and-actions)
* [Views](#views)
* [ViewModels](#viewmodels)	
* [Configuration](#configuration)
* [Database](#database)

**Current version**: 0.3.0-alpha released on 15.09.2019

_This is just a hobby project but it is continuously being worked on._
## Roadmap
* Logging
* Session and Cookie handling
* ORM
* ViewEngine
* ...

# Getting started

## Installation

### Download
Download the latest version at [Github](https://github.com/avolutions/avolutions/archive/0.3.0-alpha.zip) or [avolutions.de](http://avolutions.de/download).
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
  
Configuration key | Default value | Description | Since
------------ | ------------- | ------------- | -------------
database/host | 127.0.0.1 | The host name for the database connection | 0.3.0-alpha 
database/database | avolutions | The database name for the database connection | 0.3.0-alpha
database/user | avolutions | The username for the database connection | 0.3.0-alpha
database/password |  | The password for the database connection | 0.3.0-alpha
database/migrateOnAppStart | true | Controls if migrations are running automatically or not | 0.3.0-alpha
logger/debug | true | Controls if debug log message will be write to the logfile or not | 0.4.0-alpha
logger/logfile | logfile.log | The name of the logfile | 0.4.0-alpha
logger/logpath | CORE_PATH."log".DIRECTORY_SEPARATOR | The path where the logfile is stored | 0.4.0-alpha
logger/datetimeFormat | "Y-m-d H:i:s.v" | The format for the datetime of the log message | 0.4.0-alpha

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

### Database
The __Database__ module provides some functions to connect to a MySQL database, execute queries and perform schema changes (migrations) on the database.
#### Database connection
To connect to a MySQL database you have to configure your connection parameters. Have a look to the _config/database.php_ __Configuration__ file. There are four __Configuration__ values to configure: _host_, _database_, _user_, _password_. To create a new connection to the __Database__ just call the constructor of the __Database__ class:  
```php
<?php	 
  use core\database\Database;
 
  $Database = new Database();
?> 
```
#### Database queries
To execute queries on your __Database__ you can just use the _query()_ method of the __Database__ class:  
```php
<?php	 
  use core\database\Database;
 
  $Database = new Database();
  $stmt = $Database->query('SELECT * FROM user');
  while ($row = $stmt->fetch()) {
    print $row['Firstname'];
  }
?> 
```
Because the avolutions __Database__ class extends the PHP __PDO__ class it is possible to use all methods from it, e.g. _prepared statements_, _transactions_...
#### Database migration
To made changes to your database schema (add or remove tables/columns etc.) the avolutions framework provides a bunch of methods. These method can be use to write _migrations_ for your __Database__. The framework will check for the current version of your __Database__ and execute changes if they are not added to the __Database__ schema already.  
By default the _migrations_ will be executed automatically, if you do not want this you have to change the value of _database/migrateOnAppStart_ to _false_. To exectue the _migrations_ by yourself use the following code:
```php
<?php	 
  use core\database\Database;
 
  Database::migrate();
?> 
```

To create a new _migration_ add a new file in _application/database_, e.g. _CreateUserTable.php_. This file has to contain a class (with the same name as the file) which has a property _version_ and a method _migrate_:
```php
<?php
  class CreateUserTable {
    public $version = "";

    public function migrate() {
    }
  }
?>
```
All _migrations_ in the _application/database_ folder will be executed in the order of the version, from low to high. The version should be unique, best practice is to use the current datetime of the creation, e.g. "_20190915143000_".  

#### Create new table
To create a new table use the method _Table::create($tableName, $Columns)_:
```php
<?php
use core\database\Table;
use core\database\Column;

class CreateUserTable {
  public $version = "20190915143000";

  public function migrate() {
    $columns = array();
	// $name, $type, $length , $default, $null, $primaryKey, $autoIncrement
    $columns[] = new Column("UserID", Column::INT, 255, null, null, true, true);
    $columns[] = new Column("Firstname", Column::VARCHAR, 255);
    $columns[] = new Column("Lastname", Column::VARCHAR, 255);	
    Table::create("user", $columns);
  }
}
?>
```

#### Add column to table
To add a new column to a table use the method _Table::addColumn($tableName, $Column, $after = null)_:
```php
<?php
use core\database\Table;
use core\database\Column;

class AddMailToUserTable {
  public $version = "20190915143100";

  public function migrate() {
    Table::addColumn("user", new Column("Mail", Column::VARCHAR, 255), "UserID");
  }
}
?>
```

#### Remove column from table
To remove a column from a table use the method _Table::removeColumn($tableName, $columnName)_:
```php
<?php
use core\database\Table;
use core\database\Column;

class RemoveMailFromUserTable {
  public $version = "20190915143200";

  public function migrate() {
    Table::removeColumn("user", "Mail");
  }
}
?>
```

#### Add index to table
To add an index (_index_, _unique_, _primary key_) to a table use the method _Table::addIndex($tableName, $indexType, $columnNames, $indexName)_:
```php
<?php
use core\database\Table;
use core\database\Column;

class AddUniqueIndexToUserTable {
  public $version = "20190915143300";

  public function migrate() {
    Table::addIndex("user", Table::UNIQUE, array("Firstname", "Lastname"), "UniqueName");
  }
}
?>
```

#### Add foreign key constraint to table
To add an foreign key constraint to a table use the method _Table::addForeignKeyConstraint($tableName, $columnName, $referenceTableName, $referenceColumnName, $onDelete, $onUpdate, $constraintName)_:
```php
<?php
use core\database\Table;
use core\database\Column;

class AddForeignKeyToUserTable {
  public $version = "20190915143400";

  public function migrate() {
    Table::addForeignKeyConstraint("user", "UserID", "user_role", "UserID");
  }
}
?>
```

# License
The AVOLUTIONS framework is an open source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
