# Contribution Guide

_Make sure you read this before sending a pull request._

[Since 0.5.0]

- [Introduction](#introduction)
    - [The Pletfix Philosophy](#philosophy)
    - [Coding Style](#coding-style)
- [Pletfix Repositories](#repositories)
    - [Application Skeleton](#app)
    - [Core](#core)
    - [Documentation](#docs)
    - [Plugins](#plugins)

<a name="introduction"></a>
## Introduction

Everyone is welcome to contribute to the Pletfix framework. 
Would you solve something more elegantly in the framework? Or are you missing a function? 
Then fork the repository and realize your ideas!

<a name="philosophy"></a>
### The Pletfix Philosophy

You should follow the proven software design paradigm, in particular:

- [KISS principle](https://en.wikipedia.org/wiki/KISS_principle) - Keep it simple, stupid
- [DRY principle](https://en.wikipedia.org/wiki/Don't_repeat_yourself) - Don’t repeat yourself
- [Convention over Configuration](https://en.wikipedia.org/wiki/Convention_over_configuration)
- [SRP principle](https://en.wikipedia.org/wiki/Single_responsibility_principle) - Single Responsibility Principle

The most important thing for Pletfix is the first point: **Keep it simple**! If you want to implement something, try to 
find the most easiest way with as little code as possible. 

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Do not write an insane construct with hundreds of objects and files, if you can also do it with just a few classes!

Also make sure that the external packages you are using are slim as well. Of course, the packages themselves should not 
include tons of other packages.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Choose third-party packages carefully so that the KISS principle is not violated!

<a name="coding-style"></a>
### Coding Style

Pletfix follows...

- the [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) coding standard,
- the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding style guide and 
- the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard.

See also [www.php-fig.org](http://www.php-fig.org/psr/) for more Standards Recommendations of the PHP Framework Interop Group.

<a name="repositories"></a>
## Pletfix Repositories

<a name="app"></a>
### Application Skeleton

Fork the repository <https://github.com/pletfix/app> if you want to develop at the Pletfix Application Skeleton.

<a name="docs"></a>
### Documentation

If you are interested in contributing a translation this documents, read the README of <https://github.com/pletfix/docs>.  

<a name="plugins"></a>
### Plugin Example

Do you have an idea to extend the framework? Then write a plugin. Read the chapter [Plugins](plugins#writing) to learn 
how you can do it. You can download a example from [GitHub](https://github.com/pletfix/hello).

<a name="core"></a>
### Core

If you want to develop at the Pletfix Core, fork the repository <https://github.com/pletfix/core>. 

We recommend that you set up a workbench as follows, so that you can test and verify the changes to the core directly in 
an application:

1. Install a fresh [Pletfix Application](https://github.com/pletfix/app)

2. Remove the Pletfix Core in the vendor path: 

       rm -R vendor/pletfix/core
    
3. Create a folder `workbench` in the project folder and clone your fork of the Pletfix Core to this folder:
   
       mkdir workbench
       cd workbench
       mkdir pletfix
       cd pletfix
       git clone <your-fork> core

4. Modify `composer.json` as below:

    - In the `require` section, remove the `"pletfix/core": "dev-master"` entry and insert all required packages from 
      the core instead.
    - Add `"Core\\": "workbench/pletfix/core/src/"` to the `psr-4` autoload section.
    - Add the core's helper file into the `files` autoload section.
    
    After this the `autolaod` section looks like below:
       
        "require": {
            "php": ">=5.6.4",
            "doctrine/cache": "^1.6",
            "doctrine/inflector": "^1.1",
            "jdorn/sql-formatter": "^1.2",
            "leafo/scssphp": "^0.6.6",
            "monolog/monolog": "~1.11",
            "natxet/cssmin": "^3.0",
            "oyejorge/less.php": "v1.7.0.10",
            "paragonie/random_compat": "^2.0",
            "psr/http-message": "~1.0",
            "tedivm/jshrink": "^1.1",
            "vlucas/phpdotenv": "~2.2"
        },
        "require-dev": {
            "behat/mink": "^1.7",
            "behat/mink-browserkit-driver": "dev-master",
            "behat/mink-goutte-driver": "^1.2",
            "phpunit/phpunit": "^5.7|^6.0",
            "npm-asset/bootstrap": "^3.3.7",
            "npm-asset/eonasdan-bootstrap-datetimepicker": "^4.17.37",
            "npm-asset/font-awesome": "^4.6.3",
            "npm-asset/jquery": "^2.2.4",
            "npm-asset/moment": "^2.10",
            "npm-asset/selectize": "^0.12.3"
        },
        "autoload": {
            "classmap": [
                "library/classes",
                "library/facades"
            ],
            "files": [
                "library/functions/helpers.php",
                "workbench/pletfix/core/helpers.php"
            ],
            "psr-4": {
                "App\\": "app/",
                "Core\\": "workbench/pletfix/core/src/",
            }
        }    
    