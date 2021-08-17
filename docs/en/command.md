# Commands

* [Introduction](#introduction)

## Introduction

*AVOLUTIONS* framework provides *Commands* to help you build and maintain your application in a faster way.
You can also create your own *Commands*. 

## Run commands

*Commands* are typically executed by a *Console Application*, but you can also execute them programmatically.

### Console

The easiest way to execute *AVOLUTIONS* *Commands* is to use the `avolute` script available in the [App Template](https://github.com/avolutions/app):
```bash
> php avolute <command_name> [arguments] [options]
```

### Programmatically

To run a *Command* from code use [`command()` helper](helper.md#command).
Just pass the same command string as if you are using `avolute` or pass an array containing all arguments and options:
```php
command('<command_name> [arguments] [options]');
// or
command(['<command-name>', '[argument]', '[option]']);
```

## Arguments and Options

Every *Command* can have *Arguments* and *Options* to receive input from the *Command Line*.
To get a list of all available *Arguments* and *Options* for a *Command* use the `help` option:
```bash
> php avolute <command_name> -h
```

### Arguments

*Arguments* are used to pass values to a *Command*, like a parameter in a method. 
*Arguments* are positional, therefore required *Arguments* must be defined before optional *Arguments*.

To run a *Command* with an *Argument*, just add the value to the command string.

Let's say we have a *Command* named "test-command", and it accepts two *Arguments*: "name" and "shortname" (optional).
You can run the *Command* like the following:
```bash
> php avolute test-command foo bar
```
In this case the *Arguments* have the following values: name = "foo", shortname = "bar"
```bash
> php avolute test-command foo
```
In this case the *Arguments* have the following values: name = "foo", shortname = null because no value was passed for this optional *Argument*.
You can also define a default value, see [Custom commands](#custom-commands).
```bash
> php avolute test-command
```
This example will lead in an error because no value for the mandatory "name" *Argument* was passed.

### Options

*Options* are used as boolean parameters. They can not be used to pass custom values to the *Command*.
They are either set (true) or not (false). Therefore, an *Option* is always optional.
Options can have a short alias and therefore be passed in two different ways. 
Either use the name with two leading hyphens, or the short alias with one leading hyphen:
```bash
> php avolute <command_name> --help
> php avolute <command_name> -h
```
Both calls will execute the *Command* in the same way: the `help` *Option* is set.

## Available commands

There are some built in *Commands* in *AVOLUTIONS* to help you with building your application.
To get a list of all available *Commands* you can run `avolute` without *Arguments* and *Options*:
```bash
> php avolute
```

### Create-command

This *Command* can be used to create a new `Command` class in your application.
The `src/Command/templates/command.tpl` template is used.

#### Usage
```bash
> php avolute create-command <name> [<shortname>] [options]
```

#### Arguments

* `name`: The name of the Command class without "Command" suffix.
* `shortname`: (Optional) The name to execute the command with.

#### Options

* `-f`, `--force`: Command will be overwritten if it already exists.
* `-h`, `--help`: Display help text for command.

### Create-controller

This *Command* can be used to create a new `Controller` class in your application.
The `src/Command/templates/controller.tpl` template is used.

#### Usage

```bash
> php avolute create-controller <name> [options]
```

#### Arguments
* `name` The name of the Controller without "Controller" suffix.

#### Options
* `-f`, `--force` Controller will be overwritten if it already exists.
* `-h`, `--help` Display help text for command.

### Create-event

This *Command* can be used to create a new `Event` class in your application.
The `src/Command/templates/event.tpl` template is used.

#### Usage
```bash
> php avolute create-event <name> [<shortname>] [options]
```

#### Arguments
* `name`: The name of the Event class without "Event" suffix.
* `shortname`: (Optional) The name to dispatch the Event with.

#### Options
* `-f`, `--force`: Event will be overwritten if it already exists.
* `-l`, `--listener`: Automatically creates a Listener for the Event.
* `-r`, `--register`: Automatically register a Listener for the Event. Only works if Option "listener" is set.
* `-h`, `--help`: Display help text for command.

### Create-listener

This *Command* can be used to create a new `Listener` class in your application.
The `src/Command/templates/listener.tpl` template is used.

#### Usage
```bash
> php avolute create-listener <name> [options]
```

#### Arguments
* `name`: The name of the Listener class without "Listener" suffix.

#### Options
* `-f`, `--force`: Listener will be overwritten if it already exists.
* `-e`, `--event`: Automatically creates an Event for the Listener.
* `-m`, `--model`: Indicates if Listener is for EntityEvent to use correct naming conventions.
* `-r`, `--register`: Automatically register an Event for the Listener. Only works if Option "event" is set. Not needed if option "model" is set.
* `-h`, `--help`: Display help text for command.

### Create-mapping

This *Command* can be used to create a new `Mapping` file in your application.
The `src/Command/templates/mapping.tpl` template is used.

#### Usage
```bash
> php avolute create-mapping <name> [options]
```

#### Arguments
* `name`: The name of the mapping file without "Mapping" suffix.

#### Options
* `-f`, `--force`: Mapping file will be overwritten if it already exists.
* `-m`, `--model`: Automatically creates a model for the mapping.
* `-h`, `--help`: Display help text for command.

### Create-migration

This *Command* can be used to create a new `Migration` class in your application.
The `src/Command/templates/migration.tpl` template is used.

#### Usage
```bash
> php avolute create-migration <name> [<version>] [options]
```

#### Arguments
* `name`: The name of the Migration class.
* `version`: (Optional) The unique version of the Migration. If none is passed the current DateTime (YmdHis) is used.

#### Options
* `-f`, `--force`: Migration will be overwritten if it already exists.
* `-h`, `--help`: Display help text for command.

### Create-model

This *Command* can be used to create a new `Model` class in your application.
The `src/Command/templates/model.tpl` template is used.

#### Usage
```bash
> php avolute create-model <name> [options]
```

#### Arguments
* `name`: The name of the Model class.

#### Options
* `-f`, `--force`: Model will be overwritten if it already exists.
* `-m`, `--mapping`: Automatically creates a mapping file for the Model.
* `-d`, `--migration`: Automatically creates a Migration for the Model.
* `-l`, `--listener`: Automatically creates a Listener for the Model.
* `-h`, `--help`: Display help text for command.

### Create-validator

This *Command* can be used to create a new `Validator` class in your application.
The `src/Command/templates/validator.tpl` template is used.

#### Usage
```bash
> php avolute create-validator <name> [options]
```

#### Arguments
* `name`: The name of the Model class without "Validator" suffix.

#### Options
* `-f`, `--force`: Validator will be overwritten if it already exists.
* `-h`, `--help`: Display help text for command.

### Database-migrate

This *Command* can be used to run all not executed migrations.

#### Usage
```bash
> php avolute database-migrate [options]
```

#### Options
* `-h`, `--help`: Display help text for command.

### Database-status

This *Command* can be used to show all executed migrations.

#### Usage
```bash
> php avolute database-status [options]
```

#### Options
* `-h`, `--help`: Display help text for command.

### Register-listener

This *Command* can be used to register a `Listener` for an `Event` in your application.
The `src/Command/templates/registerListener.tpl` template is used.

#### Usage
```bash
> php avolute register-listener <event> [<listener>] [<method>] [options]
```

#### Arguments
* `event`: The name of the Event class without "Event" suffix.
* `listener`: (Optional) The name of the Listener class without "Listener" suffix. If none is given, the name of the Event including "Event" suffix ist used.
* `method`: (Optional) The method of the Listener that should be called. Default value is "handleEvent".

#### Options
* `-n`, `--namespace`: Register the Event with namespace.
* `-h`, `--help`: Display help text for command.

## Custom commands

Beside the existing *Commands*, you can create custom *Commands* for your application.
Just add a new *Command* to *application/Command* and extend the base class `AbstractCommand`.

The Easiest way to create a new `Command` is to use the [`create-command` command](command.md#create-command).

After extending the `AbstractCommand` class, you need to implement two methods:
* `initialize()`: This method is called before the execution of your *Command*. You need to add your [*Arguments* and *Options* definition](#add-arguments-and-options) here.
* `execute()`: This method is called if you run the *Command*. Add the [task/logic](#execute) for your *Command* here.
### Name

Every *Command* needs a unique name to run the *Command* with.
By default, the name of the *Command* is the class name without the suffix "Command".
E.g., if your *Command* class is named `FooBarCommand`, the name of your *Command* is `FooBar` and it is executed like this:
```bash
> php avolute FooBar
```

To change the name of your *Command* just set the property `$name`:
```php
namespace Application\Command;

use Avolutions\Command\AbstractCommand;

class FooBarCommand extends AbstractCommand
{
    protected static string $name = 'foo-bar';
}
```
Now your *Command* can be ran like this:
```bash
> php avolute foo-bar
```
The name must not contain spaces.

### Description

By default, every *Command* provides the `help` *Option*. This *Option* displays a description of the *Command*, how to 
use it and a list of all available *Arguments* and *Options*.

To add a description to your *Command* just set the property `$description`:
```php
namespace Application\Command;

use Avolutions\Command\AbstractCommand;

class FooBarCommand extends AbstractCommand
{
    protected static string $name = 'foo-bar';
    protected static string $description = 'This is the foo-bar Command!';
}
```
This will lead to the following output if you run the *Command* with `help` *Option*.
```bash
> php avolute foo-bar -h
```
```
This is the foo-bar Command!

Usage:
  foo-bar [options]

Options:
  -h, --help    Display help text for command.
```

### Add Arguments and Options

*Arguments* and/or *Options* should be added in the `initialize()` method.
They are added by using the methods `addArgumentDefinition()` and `addOptionDefinition()`.
Both are accepting an `Argument` or `Option` object.

An `Argument` has the following properties:
* `name`: Name of the Argument
* `description`: (Optional) Help text for the Argument.
* `optional`: (Optional) Indicates if Argument is optional (true) or not (false).
* `default`: (Optional) Default value if no value is passed for optional Argument.

An `Option` has the following properties:
* `name`: Name of the Option.
* `short`: (Optional) Short name of the Option.
* `help`: (Optional) Help text for the Argument.
* `default`: (Optional) Default value of the Option.

Let's add an *Argument* and an *Option* to our `FooBarCommand`:
```php
namespace Application\Command;

use Avolutions\Command\AbstractCommand;

class FooBarCommand extends AbstractCommand
{
    protected static string $name = 'foo-bar';
    protected static string $description = 'This is the foo-bar Command!';
    
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('foo', 'The foo argument.'));
        $this->addOptionDefinition(new Option('bar', 'b', 'The bar option.'));
    }
}
```
This will lead to the following output if you run the *Command* with `help` *Option*.
```bash
> php avolute foo-bar -h
```
```
This is the foo-bar Command!

Usage:
  foo-bar <foo> [options]
  
Arguments:
  foo   The foo argument.

Options:
  -b, --bar     The bar option.
  -h, --help    Display help text for command.
```

Our *Command* now accepts a value for the *Argument* `foo` and you can pass a boolean flag called `bar`.
To retrieve the values passed to *Arguments* and *Options* in your `Command` class use `getArgument()` and `getOption()`:
```bash
> php avolute foo-bar test -b
```
```php
$this->getArgument('foo'); // test
$this->getOption('bar'); // true
```

### Execute

The main logic or task of your *Command* goes to the `execute()` method. 
This method is called whenever a command is dispatched (either by `avolute`, [command helper](helper.md#command) or `CommandDispatcher`).

The method needs to return an integer representing the exit status. The status 0 means the program is terminated successfully, 1 means there was an error.
You can use the constants `ExitStatus::SUCCESS` and `ExitStatus::ERROR` as return values.

To write output to *Console* your can use the *Console* object of the *Command* instance by using `$this->Console`.
For details about *Console* output check the [Console guide](console.md).

```php
namespace Application\Command;

use Avolutions\Command\AbstractCommand;
use Avolutions\Command\ExitStatus;

class FooBarCommand extends AbstractCommand
{
    protected static string $name = 'foo-bar';
    protected static string $description = 'This is the foo-bar Command!';
    
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('foo', 'The foo argument.'));
        $this->addOptionDefinition(new Option('bar', 'b', 'The bar option.'));
    }
    
    public function execute() : int{
        if ($this->getOption('bar')) {
            $this->Console->write($this->getArgument('foo'));
        }
        
        return ExitStatus::SUCCESS;
    }
}
```

This example will output the value of *Argument* "bar" whenever the *Command* is dispatched with *Option* "bar".

### Custom templates

Some built in *Commands* are used to create new classes or files in your *Application* based on template files.

If you want to use your own template, you can store a file with the same name in `application/Command/templates` directory.
The original template files can be found in `src/Command/templates/`.