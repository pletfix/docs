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

<a name="core"></a>
### Core

If you want to develop at the Pletfix Core, follow the instructions on <https://github.com/pletfix/core> to create a workbench. 

<a name="docs"></a>
### Documentation

If you are interested in contributing a translation this documents, read the README of <https://github.com/pletfix/docs>.  

<a name="plugins"></a>
### Plugin Example

Do you have an idea to extend the framework? Then write a plugin. You can download a example from [GitHub](https://github.com/pletfix/hello). 