# Logging

* [Introduction](#introduction)
* [Configuration](#configuration)
* [Usage](#usage)

## Introduction

To log messages to a logfile the Logger class is introduced. There are eight different log levels from high to low:
*EMERGENCY*, *ALERT*, *CRITICAL*, *ERROR*, *WARNING*, *NOTICE*, *INFO*, *DEBUG*.

## Configuration

The path and name of the logfile are [configured](config.md) in *config/logger.php*. Messages with level *DEBUG* will only be logged if the config parameter *logger/debug* is set to true.

## Usage

The Logger can be used like this:
```php
use Avolutions\Logging\Logger;

Logger::emergency('This is an emergency log message');
Logger::alert('This is an alert log message');
Logger::critical('This is an critical log message');
Logger::error('This is an error log message');
Logger::warning('This is an warning log message');
Logger::notice('This is an notice log message');
Logger::info('This is an info log message');
Logger::debug('This is an debug log message');
```
This will lead to the following output in the logfile:
```php
[EMERGENCY] | 2019-10-03 14:13:57.696 | This is an emergency log message
[ALERT] | 2019-10-03 14:13:57.696 | This is an alert log message
[CRITICAL] | 2019-10-03 14:13:57.697 | This is an critical log message
[ERROR] | 2019-10-03 14:13:57.697 | This is an error log message
[WARNING] | 2019-10-03 14:13:57.698 | This is an warning log message
[NOTICE] | 2019-10-03 14:13:57.698 | This is an notice log message
[INFO] | 2019-10-03 14:13:57.698 | This is an info log message
[DEBUG] | 2019-10-03 14:13:57.699 | This is an debug log message
```