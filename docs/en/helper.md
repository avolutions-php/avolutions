# Helpers

* [Introduction](#introduction)
* [Helpers](#helpers)
  * [command](#command)
  * [interpolate](#interpolate)
  * [JsonHelper::decode](#jsonhelperdecode)
  * [translate](#translate)

## Introduction

AVOLUTIONS provides a collection of global helper functions. These helpers are available in every place of your application.

## Helpers

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

### interpolate()

With this helper placeholders in a string can be replaced. The placeholders must be in braces.
You can either use numeric placeholders and pass a numeric array or use strings as placeholder and pass a associative array.  
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