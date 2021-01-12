A route is the mapping between the requested URL and the [Controller](controller.md) and Action that will be called and executed.

All Routes of your application will be defined in *./routes.php*. The Routes has to be added to the *RouteCollection* by using the *addRoute()* method.

#### Create a new Route

A Route object can have three parameters:
1. The URL that should be mapped
```php
@param string $url The URL that will be mapped
```
2. The configuration for the Controller, Action and HTTP-Method as an associative array
```php
@param array $defaults Default values for the Route
  $defaults = [
    'controller' => string Name of the controller
    'action'     => string Name of the action
    'method'     => string Name of the method (GET|POST)
  ]
```
3. The configuration for the Parameters as an multidimensional associative array
```php
@param array $parameters An array which contains all parameters and their options
  '{param}' = [  => string Name of the parameter
    'format'   => string RegEx for valid format
    'optional' => bool   If true the parameter is optional
    'default'  => string Default value for the parameter if it is optional
  ]
```

##### Examples
###### Call a static Controller and Action

```php
$RouteCollection->addRoute(new Route('/login',
  [
    'controller' => 'auth',
    'action'	 => 'login'
  ]
));
```
This Route will call the *loginAction()* method of the *AuthController*, every time someone request the URL *http://yourapp/login*.

###### Call a dynamic Controller and Action

```php
$RouteCollection->addRoute(new Route('/&lt;controller>/&lt;action>'));
```
This Route uses the reserved keywords. These keywords can be used to call *Controllers* and *Actions* based on the requested URL.
If a user requests the URL *http://yourapp/user/create* the routing engine will call the *createAction()* method of the *UserController* in this example.

###### Call a Route with Parameter(s)

```php
$RouteCollection->addRoute(new Route('/user/&lt;id>',
  [
    'controller' => 'user',
    'action'	 => 'show'
  ],
  [
    'id' => [
      'format'   => '[0-9]',
      'optional' => true,
      'default'  => 1
    ]
  ]
));
```

In this example the Route contains a placeholder (inside the angle brackets) for a parameter ("id") in the URL.
There can be a configuration for every parameter in the URL (3rd parameter of the Route object).
The configuration consists of three parts:
1. **format**: A regular expression to check the valid format of the parameter
2. **optional**: A flag that indicates if the parameter is optional (true) or not (false = default)
3. **default**: A value which will be used if the optional parameter is not passed

In this example the following requests will lead to the following results:

Request | Result
--- | ---
http://yourapp/user/15 | UserController->showAction($id) with $id = 15 will be called
http://yourapp/user | UserController->showAction($id) with $id = 1 (default) will be called.
http://yourapp/user/abc | Will lead to an error because format not matched