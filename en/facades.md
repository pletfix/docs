# Facades

[Since 0.5.0]

- [Introduction](#introduction)
- [How Facades Work](#how-facades-work)
- [When To Use Facades](#when-to-use-facades)
- [Facades vs. Helper Functions](#facades-vs-helper-functions)

> This manual based on the original Documentation of [Laravel's Facade](https://raw.githubusercontent.com/laravel/docs/5.4/facades.md).
> It's open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<a name="introduction"></a>
## Introduction

Facades provide a "static" interface to classes that are available in the [Dependency Injector](/docs/master/en/di). 

All of Pletfix's facades are defined in the global namespace and stored in the folder `library/facades/`. 
So, we can easily access a facade like so:

    Logger::debug('foo');
    
<a name="how-facades-work"></a>
## How Facades Work

Pletfix's facades, and any custom facades you create, will extend the base `Core\Services\Facade` class.

If we call as example `Logger::debug('foo')`, the `debug` method of an instance of `Core\Services\Logger` will be called.  

If you look at that `Logger` class in `library/facades/Logger.php`, you'll see that there is nothing:

    class Logger extends \Core\Services\Facade
    {
    }

How is that possible? 

Pletfix's facades, and any custom facades you create, will extend the base `Core\Services\Facade` class.

The magic is the `__callStatic()` method using the extended facade. `__callStatic()` 
(see [PHP Documentation](http://php.net/manual/en/language.oop5.overloading.php#object.callstatic)) is executed if the 
called method does not exist. In this case the service instance with the same name as the facade is get from the 
Dependency Injector to call the method:  

    namespace Core\Services;

    class Facade
    {
        public static function __callStatic($method, $arguments)
        {
            if (property_exists(static::class, 'serviceName')) {
                $serviceName = static::$serviceName;
            }
            else {
                $serviceName = strtolower(static::class);
            }
    
            return DI::getInstance()->get($serviceName)->$method(...$arguments);
        }
    }
    
<a name="facades-vs-helper-functions"></a>
## Facades vs. Helper Functions

Facades have many benefits. They provide a terse, memorable syntax that allows you to use Pletfix's features without 
remembering long class names that must be injected or configured manually. 
Furthermore, because of their unique usage of PHP's dynamic methods, they are easy to test.

However, some care must be taken when using facades:
- The primary danger of facades is class scope creep.
- The IDE have no information about the available methods unless you copy the PHP documentation block from the service 
  class to the facade like below:

        /**
         * Logger
         *
         * @method static bool debug($message, array $context = []) Adds a log record at the DEBUG level.
         */
        class Logger extends \Core\Services\Facade
        {
        }
         
- The execution speed gets worse by numerous calls of the magic method `__callStatic()`.

The last point is the reason that the facade is not Pletfix's preferred kind to access a service.
It's better to use "helper" functions.  

For example, this facade call and helper call are equivalent:

    Logger::debug('foo');

    logger()->debug('foo');

There is absolutely no practical difference between facades and helper functions except the function gets the service 
from the Dependency Injector directly without any magic:

    function logger()
    {
        return DI::getInstance()->get('logger');
    }

Pletfix includes a variety of "helper" functions to access a service in a shortcut way in `vendor/pletfix/core/functions/services.php`.
