# Installation

* [System requirements](#system-requirements)
* [Installing AVOLUTIONS](#installing-avolutions)
  * [Installing with Composer](#installing-with-composer)
  * [Installing manually](#installing-manually)
* [Configuration](#configuration)
  * [Document root](#document-root)
  * [URL rewriting](#url-rewriting)

## System requirements

The AVOLUTIONS framework has only a few requirements:
* HTTP Server (only Apache supported at the moment)
* PHP >= 7.3
* PDO PHP Extension

## Installing AVOLUTIONS

The AVOLUTIONS framework can be installed by using the Composer package manager or by downloading the sources.
We recommend to use composer for installation.

### Installing with Composer

Make sure you installed Composer like described in the official [Composer documentation](https://getcomposer.org/).

To install a new AVOLUTIONS project use the composer ```create-project``` command:
```bash
composer create-project --prefer-dist avolutions/avolutions:0.*@alpha myproject
```

### Installing manually

You can download the latest version at [Github](https://github.com/avolutions/avolutions) or [in the download section](https://avolutions.org/download). Just unpack the downloaded sources.

After the installation your folder structure should look like the following:
```bash
/
  application/
    ...
  config/
  public/
    index.php
    .htaccess
  src/
    ...
```
## Configuration
### Document root

The *public/index.php* file will be the entry point for every HTTP request (*front controller*).
Therefore the *public* folder has to be defined as the web servers document root.

### URL rewriting

The *public/.htaccess* file provides default rewrite rules (pretty URLs). Be sure to enable the mod_rewrite module for your Apache.
