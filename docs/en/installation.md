# Installation

* [System requirements](#system-requirements)
* [Installing AVOLUTIONS](#installing-avolutions)
  * [Installing with Composer](#installing-with-composer)
* [Configuration](#configuration)
  * [Document root](#document-root)
  * [URL rewriting](#url-rewriting)

## System requirements

The AVOLUTIONS framework has only a few requirements:
* HTTP Server (only Apache supported at the moment)
* PHP >= 8.0
* PDO PHP Extension

## Installing AVOLUTIONS

The AVOLUTIONS framework can be installed by using the Composer package manager.

### Installing with Composer

Make sure you installed Composer like described in the official [Composer documentation](https://getcomposer.org/).

If starting a new project, we highly recommend to us our [app template](https://github.com/avolutions/app).
To install a new AVOLUTIONS project use the composer ```create-project``` command:
```bash
composer create-project --prefer-dist avolutions/avolutions:0.*@alpha myproject
```

Or AVOLUTIONS can be installed into your existing project by using the composer ```require``` command:  
```composer require avolutions/avolutions:0.*@alpha```

## Configuration
### Document root

The *public/index.php* file will be the entry point for every HTTP request (*front controller*).
Therefore, the *public* folder has to be defined as the web servers document root.

### URL rewriting

The *public/.htaccess* file provides default rewrite rules (pretty URLs). Be sure to enable the mod_rewrite module for your Apache.