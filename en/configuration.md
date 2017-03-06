# Configuration

[Since 0.5.0]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Environment](#environment)

<a name="introduction"></a>
## Introduction

<a name="environment"></a>
## Environment

The environment file `.env` is a simple key/value list. 
Variables are stored here, which are dependent on the server environment.
In addition, The file contains sensitive data, e.g. passwords.
The latter is the reason why the file is ignored by Git and instead a sample file `env.exsample` is pushed in the 
git repository.

<a name="configuration"></a>
## Configuration

All configuration files are stored in the `config` folder. 

<a name="receiving"></a>
### Receiving Configuration Variable

The `config` function gets the value of a configuration variable. 

The configuration values may be accessed using "dot" syntax, which includes the name of the file and the option you 
wish to access: 

    $timezone = config('app.timezone');

A default value may be specified and is returned if the configuration option does not exist:

    $debugMode = config('app.debug', 'false'); 
 
 
<!--
TODOS:
- Caching Mechanismus
- config/boot/bootsrap.php
- config/boot/routes.php
- config/boot/services.php
- vendor/pletfix/core/src/Bootstraps/LoadConfiguration.php
- Plugin Configuration
--> 
