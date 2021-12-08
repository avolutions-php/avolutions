# Application

* [Introduction](#introduction)
* [Structure](#structure)
  * [Application template](#application-template)
  * [Application directory](#application-directory)
* [Customize your application](#customize-your-application)
  * [Application folder(s)](#application-folders)
  * [Application namespace(s)](#application-namespaces)

# Introduction

We highly recommend using [AVOLUTIONS Application Template](https://github.com/avolutions/app) to build an application with AVOLUTIONS.
This template is designed to start developing your application without any further configurations.

# Structure

Read the following chapters to understand the basic structure of an AVOLUTIONS application.

## Application template

The Application template comes with the following folders and files:
```
├── public
│   ├── .htaccess
│   ├── favicon.ico
│   └── index.php
├── .gitignore
├── LICENSE
├── README.md
├── avolute
├── bootstrap.php
├── composer.json
├── events.php
└── routes.php
```

Folder/file | Description
--- | ---
.gitignore | File to tell git which files/folders should be ignored. By default, there are some folder like `vendor/` and IDE specific files added. You can customize this file four your needs.
avolute | PHP Script to execute the `avolute` command, see chapter [Commands](command.md).
bootstrap.php | This file will bootstrap your application. [Customizing](#customize-your-application) of your application folders/namespaces and/or configure of DI container can be done in this file.
composer.json | Default composer information. Can be customized for your application.
events.php | All [Events and Listener](event.md) should be defined in this file. There is already a `$ListenerCollection` defined.
LICENSE | Contains the AVOLUTIONS license. Can be changed, if your application is developed under a license.
public/ | The `public` directory contains the entry point for your application (see `index.php`). Also, all assets like images, CSS and JavaScript files should be stored here.
public/.htaccess | The `.htaccess` file provides default rewrite rules (pretty URLs).
public/favicon.ico | A default favicon, can be replaced with your own.
public/index.php | The `index.php` file is the entry point for every request of your application (`front controller`). It includes the `bootstrap.php`, `events.php`, `routes.php`.
README.md | A readme file for the repository. You can change this file and add application specific information.  
routes.php | All [Routes](routing.md) should be defined in this file. There is already a `$RouteCollection` defined.

## Application directory

All your application specific files goes to the application directory. 
By default, AVOLUTIONS is using a directory called `application` in the root level of the Application template.

After creating the `application` folder, your directory should look something like this:
```
├── application
├── public
│   ├── .htaccess
│   ├── favicon.ico
│   └── index.php
├── .gitignore
├── ...
```

AVOLUTIONS needs you to put your files in the following folders.  
If you want to use other directory names for your application, see chapter [Customize your application](#customize-your-application).

Folder | Description
--- | ---
application | Base directory for application files.
application/Command | Store all [Command](command.md) classes here.
application/Command/templates | Store all [Command template](command.md#custom-templates) files here.
application/Config | Store all [Config](config.md) files here.
application/Controller | Store all your [Controllers](controller.md) here.
application/Database | Store all [Database Migrations](migration.md) here.
application/Event | Store all [Event](event.md) classes here.
application/Listener | Store all [Event Listener](event.md#create-a-listener) here.
application/Mapping | Store all [Entity Mapping](mapping.md) files here.
application/Model | Store all [Entities](model.md) here.
application/Translation | Store all [Translation](translation.md) files here.
application/Validator | Store all custom [Validators](validation.md) here.
application/View | Store all [Views](view.md) here.

# Customize your application

Of course, you can use your own directory and namespace names for your application.
The folders and namespaces can be passed to the `Application` class in `bootstrap.php`.

AVOLUTIONS will autoload all application files and classes by using Composer and the [PSR-4 Autoloader](https://www.php-fig.org/psr/psr-4/).

## Application folder(s)

To use custom application directories, you need to pass these to the `Application` class.
To do so, define an array with your custom paths and change the `Application` creation in `bootstrap.php`:
```php
...
$paths = [
    'app' => 'app'
    ...
];
$Application = new Application(__DIR__, $paths);
...
```
The array supports the following keys:
* 'app'
* 'command'
* 'commandTemplate'
* 'config'
* 'controller'
* 'database'
* 'event'
* 'listener'
* 'mapping'
* 'model'
* 'translation'
* 'validator'
* 'view'

If you want to change the base directory like in the example above (`app/` instead of `application/`), 
you also need to change the `autoload/psr-4` section in `composer.json`:
```json
"autoload": {
  "psr-4": {
    "Application\\": "app/"
  }
}
```

## Application namespace(s)

AVOLUTIONS needs you to put your classes in the following namespaces:

Namespace | Description
--- | ---
Application\ | Base namespace for your application.
Application\Command | Namespace for all [Command](command.md) classes.
Application\Controller | Namespace for all [Controllers](controller.md).
Application\Database | Namespace for all [Database Migrations](migration.md).
Application\Event | Namespace for all [Event](event.md) classes.
Application\Listener | Namespace for all [Event Listener](event.md#create-a-listener).
Application\Model | Namespace for all [Entities](model.md).
Application\Validator | Namespace for all custom [Validators](validation.md).

To use custom namespaces, you need to pass these to the `Application` class.
To do so, define an array with your custom namespaces and change the `Application` creation in `bootstrap.php`:
```php
...
$namespaces = [
    'app' => 'MyApp'
    ...
];
$Application = new Application(__DIR__, null, $namespaces);
...
```
The array supports the following keys:
* 'app'
* 'command'
* 'controller'
* 'database'
* 'event'
* 'listener'
* 'model'
* 'validator'

If you want to change the base namespace like in the example above (`MyApp\\` instead of `Application\\`),
you also need to change the `autoload/psr-4` section in `composer.json`:
```json
"autoload": {
  "psr-4": {
    "MyApp\\": "application/"
  }
}
```