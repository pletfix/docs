# Configuration

[Since 0.5.0]

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
Variables should be stored here that are dependent on the server environment, or sensitive data, e.g. Passwords.
The latter is the reason why the file is ignored by Git and instead a sample file `env.exsample` is pushed in the git 
repository.

To read the environment, Pletfix uses [PHP dotenv](https://github.com/vlucas/phpdotenv) by Vance Lucas, licensed under 
[BSD-3](https://github.com/vlucas/phpdotenv/blob/master/LICENSE.txt).

You may use the `env()` helper function to retrieve environment variables from your configuration files.

**IMPORTANT:**

If the configuration files were [cached](#caching), `.env` is not read. Therefore you should never use the `env()` 
function directly, instead only in the configuration files!

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
 
<a name="caching"></a>
## Caching

Pletfix will cache the configuraton files into a single static file automatically to speed up the boot process. 
The file will be stored in `stored/cache/config.php`. If you modify the configuration files under the `config` folder, 
Pletfix will update the cache at the next browser request.

<a name="boot-files"></a>
## Boot Files

The following files are stored in the `config/boot` folder. They are loaded during the boot process.

- `bootstrap.php` - Register the bootstrapper to load the configuration and register the Exception Handler(errors)
- `routes.php` - [Define the HTTP Routing](routing)
- `services.php` - Bind [services](helpers) to the [Dependency Injection](di)

You may edit this files to modify the boot process as you wish.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Furthermore, the services, bootstraps and default routes of the installed plugins will be loaded during the boot process.
> To find out what it is, look in the `.manifest` folder. But do not carry out any change manually in this folder! 
> The files are automatically generated and changed when you [register or remove plugins](plugins#registering).
> Instead, you can override the services and routes of a plugin by adding the entries in `config/boot/services.php` and 
> `config/boot/services.php`.