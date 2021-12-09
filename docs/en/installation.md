# Installation

* [System requirements](#system-requirements)
* [Installing AVOLUTIONS](#installing-avolutions)
  * [Installing with Composer](#installing-with-composer)
  * [Using GitHub template](#using-github-template)
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
To install a new AVOLUTIONS application use the composer `create-project` command:
```bash
composer create-project --prefer-dist avolutions/app myproject
```

Or AVOLUTIONS can be installed into your existing project by using the composer `require` command:
```bash
composer require avolutions/avolutions:0.*
```

### Using GitHub template

You can easily start a new AVOLUTIONS application by using our GitHub app template.
Open the [AVOLUTIONS app repository](https://github.com/avolutions/app) and click the button "Use this template".
You can now create a new repository based on our application template.

## Configuration
### Document root

The *public/index.php* file will be the entry point for every HTTP request (*front controller*).
Therefore, the *public* folder has to be defined as the web servers document root.

### URL rewriting

The *public/.htaccess* file provides default rewrite rules (pretty URLs). Be sure to enable the mod_rewrite module for your Apache.