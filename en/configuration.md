# Configuration

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Environment](#environment)
- [Caching](#caching)
- [Boot Files](#boot-files)

<a name="introduction"></a>
## Introduction

<a name="environment"></a>
## Environment

The environment file `.env` is a simple key / value list to set environment variables on your application level.
Variables that are dependent on the server environment or sensitive data, e.g. Passwords, should be stored here. 
The latter (the passwords) is the reason why the file is ignored by Git and instead a sample file `env.exsample` is 
pushed into the git repository.

To read the environment, Pletfix uses [PHP dotenv](https://github.com/vlucas/phpdotenv) by Vance Lucas, licensed under 
[BSD-3](https://github.com/vlucas/phpdotenv/blob/master/LICENSE.txt).

You may use the `env()` helper function to retrieve environment variables.

**IMPORTANT:**

If the configuration files were [cached](#caching), `.env` is not read. Therefore you should never use the `env()` 
function directly, but only in the configuration files!

<a name="configuration"></a>
## Configuration

All configuration files are stored in the `config` folder. 

<a name="receiving"></a>
### Receiving Configuration Variables

The `config` function gets the value of a configuration variable. 

The configuration values may be accessed using "dot" syntax, which includes the name of the file and the option you 
wish to get: 

    $timezone = config('app.timezone');

A default value may be specified and is returned if the configuration option does not exist:

    $debugMode = config('app.debug', 'false'); 
 
<a name="caching"></a>
## Caching

Pletfix will cache the configuration files into a single static file automatically to speed up the boot process. 
The file will be stored in `stored/cache/config.php`. If you modify the configuration files under the `config` folder, 
Pletfix will update the cache at the next browser request.

<a name="boot-files"></a>
## Boot Files

The following files are stored in the `boot` folder. They will be loaded during the boot process.

- `bootstrap.php` - Registers the bootstrapper to load the configuration and registers the Exception Handlers.
- `routes.php`    - [Defines the HTTP Routing](routing).
- `services.php`  - Binds [services](helpers) to the [Dependency Injection](di).

You may edit this files to modify the boot process as you wish.

<a name="plugins"></a>
### Plugins

If you have installed plugins that include services, bootstraps or default routes, they will be loaded during the boot p
rocess, too.

To find out what these plugins serve, look in the `.manifest` folder. But do not carry out any change manually in this 
folder! The files are automatically generated and changed when you [register or remove plugins](plugins#registering).
Instead, you can override the services and routes of a plugin by adding the entries in `boot/services.php` and 
`boot/routes.php`.