# Helpers

* [Introduction](#introduction)
* [Helpers](#helpers)
  * [application](#application)
  * [command](#command)
  * [config](#config)
  * [cookie](#cookie)
  * [interpolate](#interpolate)
  * [JsonHelper::decode](#jsonhelperdecode)
  * [translate](#translate)
  * [view](#view)

## Introduction

AVOLUTIONS provides a collection of global helper functions. These helpers are available in every place of your application.

## Helpers

### application()

If application helper is called without parameter it will return an `Application` instance.
If you pass an instance name, the helper will try to get this instance from `Container`.
If you pass additionally an array, the application helper will make an new instance from `Container`;
```php
$Application = application();
$TestClass = application(TestClass::class); // Container->get(TestClass::class);
$TestClass = application(TestClass::class, ['id' => 4711]); // Container->make(TestClass::class, ['id' => 4711]);
```

### command()

This helper can be used to dispatch a command programmatically. 
Either pass the command string as same as from Command Line or an array containing all arguments and options.
First argument must be the name of the command.
```php
command('create-controller Test -f');
// or
command(['create-controller', 'Test', '-f']);
```
Both examples will create a new Controller named "Test" and "force mode" using the CreateControllerCommand.

### config()

Config helper allows you to get and set config values. It accepts two parameters: `$key` and `$value` (optional).
If called only with `$key` it will return the corresponding config value:
```php
// same as $Config->get('foo/bar');
config('foo/bar');
```
If you pass an `$value`, the config helper will set a config value:
```php
// same as $Config->set('foo/bar', 'de');
config('foo/bar', 'baz');
print config('foo/bar'); // buz
```

### cookie()

This helper creates and return a new `Cookie` object. All accepted parameters can be found in [API documentation](https://api.avolutions.org/namespaces/default.html).
```php
$Cookie = cookie('name', 'value');
```

### interpolate()

With this helper placeholders in a string can be replaced. The placeholders must be in braces.
You can either use numeric placeholders and pass a numeric array or use strings as placeholder and pass an associative array.  
```php
print interpolate('Hey, my name is {0}. I\'m {1} years old.', ['Alex', 42]); // Hey, my name is Alex. I'm 42 years old.
print interpolate('Hey, my name is {name}. I\'m {age} years old.', ['age' => 42, 'name' => 'Alex']); // Hey, my name is Alex. I'm 42 years old.
```

### JsonHelper::decode()

[JsonHelper::decode()](https://api.avolutions.org/classes/Avolutions-Util-JsonHelper.html#method_decode) is a wrapper for the native `json_decode` method, that gives the possibility to not only decode JSON string but also a JSON file.
```php
print JsonHelper::decode('/path/to/file.json', true); // will return the JSON content as associative array
```
```php
$json = '{"name": "Alex", "age": 4711 }';
print JsonHelper::decode($json) // will return the JSON as an object
```

### translate()

The *translate()* helper is used to load translation strings from you translation files, like described [here](translation.md).
```php
print translate('example/welcome');
```

### view()

Returns a new `View` instance using the passed view file (see [Controller](controller.md) and [View](view.md)):
```php
view('foo/bar'); // will return view file 'application/View/foo/bar.php'
```
If no view file is provided, it will resolve the view file from calling `Controller` and `Action`: 
```php
class FooController extends Controller
{
    public function barAction()
    {
        // 'application/View/<controller>/>action>'
        return view(); // will return view file 'application/View/foo/bar.php'
    }
}
```