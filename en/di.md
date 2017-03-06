# Dependency Injection

[Since 0.5.0]

- [Introduction](#introduction)
- [Registering Services](#registering)
- [Receiving a Services](#receiving)

<a name="introduction"></a>
## Introduction

Pletfix is based on the Dependency Injection pattern, as does all modern frameworks.

For information about "Inversion of Control (IoC)" and "Dependency Injection" please consult 
<http://martinfowler.com/articles/injection.html> by Martin Fowler.

You can access the Dependency Injector like this:

    $di = \Core\Services\DI::getInstance();
    
You may also use the global `di()` function:
      
    $di = di();      


<a name="registering"></a>
## Registering Services

A service is an class or an object bound in the Dependency Injection Container under a unique name. 

The services are registered in `config/boot/services.php`. Feel free to add your own services to this file 
like this:

    $di = \Core\Services\DI::getInstance();
    
    $di->set('my-service', \App\Services\MyService::class);
    
In the example above the service is not shared. The Dependency Injector will create a new instance of `MyService` every 
time you get the service. 

#### Shared Service
 
If you like to bind the service as singleton service, set `true` as the second argument:
  
    $di->set('my-service', \App\Services\MyService::class, true);

Now any time you get the named service, you always get back the same object instance.
Note that a shared service needs a standard constructor (constructor without arguments)!

> The Pletfix Core provides a few [services](helpers) that all are defined in `vendor/pletfix/core/services`.
> A good place for your own service classes is `app/services`.  

#### Bind Object Instances

If you have already created any object, you may simply bind the instance to the service container:

    $di->set('my-service', $myService, true);

#### Closures

Another way to create a service is to define a function, not the preferred but quick solution:

    $di->set('stupid', function() {
        echo 'I am just a stupid service!';
    }, true);


<a name="receiving"></a>
## Receiving a Service
 
You may get the service like this:
 
    $config = DI::getInstance()->get('config');
    
Additional you may set an array of parameters if the constructor of the services accepts arguments:
    
    $collect = DI::getInstance()->get('collection', [$items]);

Alternative you could use the global `di()` function:

    $config = di('config');
    
    $collect = di('collection', [$items]);
    
> The second parameter will be ignored by shared services, because singletons can never have arguments in the constructor!    
    
Pletfix provides [helper functions](helpers) for an easy access to the most services. 
As example you may get a collection like this:

    $collect = collect($items);
    
Study the function library in `vendor/pletfix/core/functions/services.php` to learn more.    
    