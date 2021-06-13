# Configuration

* [Introduction](#introduction)
* [Add a new Configuration value](#add-a-new-configuration-value)
* [Override an existing Configuration value](#override-an-existing-configuration-value)
* [Use the Configuration value in application](#use-the-configuration-value-in-application)
* [Set configuration value at runtime](#set-configuration-value-at-runtime)
* [Default values](#default-values)

## Introduction
There are config files where you can store Configuration values that are available everywhere in the application.

## Add a new Configuration value

To store a new Configuration value add a new config file at *application/Config*, e.g. *user.php*.
Just return an array with all your config values as keys:
```php
return [
  'showLastname' => true
];
```

## Override an existing Configuration value

There are some core Configuration values. These values are stored in the config folder of the AVOLUTIONS core.

You should never change a file inside the core folder, otherwise there can be conflicts or data loss when updating the framework.

Therefore it is possible to overwrite the core values with your application values. Just create a config file inside the *application/Config* with the same name as the file in *core/config*.
Use the same array key to overwrite the core Configuration value.

## Use the Configuration value in application

To use the Configuration value you need to know the key. The key is composed of the file name and the array keys.

E.g. the key of the Configuration value from our example above is:*user/showLastname*.


To use the Configuration value in the application we will edit the getName() method of our ViewModel example like the following:
```php
use Avolutions\Config\Config;
...
public function getName() {
  if (Config::get('user/showLastname')) {
      return $this->firstname.' '.$this->lastname;
  }

  return $this->firstname;
}
...
```
If the Configuration value is set to true it will result in the following output:
```php
Hello Alex Vogt
```
If the Configuration value is set to false it will result in the following output:
```php
Hello Alex
```

## Set configuration value at runtime
Configuration values can be set at runtime. The value is only available for the current request and will not be stored/changed permanently.
Use the `set` method of `Config` class to add a new config value or override an already existing one:  
```php
Config::set('my/new/config', 4711);
print Config::get('my/new/config'); // 4711
```


## Default values

Configuration key | Default value | Description
--- | --- | ---
application/defaultDateFormat | "Y-m-d" | The default date format for your application. Will be used in [DateTimeValidator](validation.md#datetimevalidator) if `type` "date" is passed.
application/defaultDateTimeFormat | "Y-m-d H:i:s" | The default datetime format for your application. Will be used in [DateTimeValidator](validation.md#datetimevalidator) if `type` "datetime" is passed.
application/defaultTimeFormat | "H:i:s" | The default time format for your application. Will be used in [DateTimeValidator](validation.md#datetimevalidator) if `type` "time" is passed.
application/defaultLanguage | "en" | The default language for your application
application/namespace | "Application" | The namespace for your application
database/host | "127.0.0.1" | The host name for the database connection
database/port | "3306" | The port for the database connection
database/database | "avolutions" | The database name for the database connection
database/user | "avolutions" | The username for the database connection
database/password |  | The password for the database connection
database/migrateOnAppStart | false | Controls if migrations are running automatically or not
logger/loglevel | "DEBUG" | Only messages with a higher or equal loglevel then this will be logged
logger/logfile | "logfile.log" | The name of the logfile
logger/logpath | "./log/" | The path where the logfile is stored
logger/datetimeFormat | "Y-m-d H:i:s.v" | The format for the datetime of the log message