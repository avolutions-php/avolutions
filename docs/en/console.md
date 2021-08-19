# Console

* [Introduction](#introduction)
* [Output](#output)
  * [Write output](#write-output)
  * [Style output](#style-output)
    * [Custom style](#custom-styles)
      * [Format](#format)
      * [Color](#color)
      * [Background](#background)
    * [Predefined styles](#predefined-styles)
  * [Tables](#tables)
* [Input](#input)

## Introduction

The AVOLUTIONS framework can not only be used for web applications but also for simple Console applications.
If you are using the [AVOLUTIONS App template](https://github.com/avolutions/app) you may know the `avolute`
Console application.

## Output

To interact with the Command Line Interface is very simple. Just create a new instance of `Console` class.
This class provides some methods to write output to the CLI.

### Write output

To write output to the Console use the methods `writeLine()` and `write()`. 
They are both write a string to the Console but `writeLine()` will add a line break at the end.
You can also pass simple style information for your output for details see next chapter.
```php
use Avolutions\Console\Console;

$Console = new Console();
$Console->writeLine('This is a string with line break.');
$Console->write('This is a string without');
$Console->write(' line break.');
```
This will result in the following output:
```
> This is a string with line break.
> This is a string without line break.
```

### Style output

A command line interface allows simple styling of output. This contains *format* (bold, italic...), *text color* and *background color*.
The `write()` and `writeLine()` methods accepts style information as second parameters.
You can either pass an array containing custom style information, or the name of a predefined style.

### Custom styles

Style information are passed as an array containing of three keys: *format*, *color*, *background*.
```php 
$style = [
    'format' => /* format of the text */,
    'color' => /* color of the text */,
    'background' => /* bcakground color of the text */
];
$Console->write('This is a simple text', $style);
```
The following values are supported:

#### Format

* bold
* italic
* underline
* reverse

#### Color

* black
* red
* green
* yellow
* blue
* magenta
* cyan
* white
* gray
* lightRed
* lightGreen
* lightYellow
* lightBlue
* lightMagenta
* lightCyan
* lightWhite

#### Background

* black
* red
* green
* yellow
* blue
* magenta
* cyan
* white
* gray
* lightRed
* lightGreen
* lightYellow
* lightBlue
* lightMagenta
* lightCyan
* lightWhite

### Predefined styles

The following predefined styles are available:

Name | Style information
--- | ---
error | ``` 'color' => 'lightRed ```
success | ``` 'color' => 'green ``` 

Just pass the name as second parameter to `write()` and `writeLine()` method:
```php 
$Console->write('This is an error', 'error');
```
This will result in an output with red text color.

### Tables

You can use the `ConsoleTable` class to easily create tables for your Console Application.

Table data (header and rows) is provided as arrays and formatted automatically with the `render()` method.
You can pass all data directly to the constructor or `render()` method:
```php
use Avolutions\Console\Console;
use Avolutions\Console\ConsoleTable;

$Console = new Console();
$data = [
    ['Header 1', 'Header 2', 'Header 3'],
    ['This', 'is', 'a'],
    ['beautiful', 'table', '!']
];
$ConsoleTable = new ConsoleTable($Console, $data);
$ConsoleTable->render(); // or $ConsoleTable->render($data);
```
This will result in the following output:
```
| Header 1  | Header 2 | Header 3 |
|---------- |----------|----------|
| This      | is       | a        |
| beautiful | table    | !        |
```

By default, the first row is used as header. If you don't want to do so set the third parameter of `constructor` to false. 

If you want to add data dynamically to the table you can use the following methods:
* `setHeaders()`: Pass an array with the header values
* `addRow()`: Pass an array with row values
* `addRows()`: Pass a multidimensional array with values for multiple rows

## Input

To receive input arguments and options from the Command Line Interface you can use the predefined PHP variables `$argc` and `$argv`.
For more information, see the [PHP documentation](https://www.php.net/manual/en/reserved.variables.argv.php).