# Cache

[Since 0.5.0]

- [Introduction](#introduction)
    - [Configuration](#configuration)
        - [APC](#configuration-apc)
        - [Array](#configuration-array) 
        - [File](#configuration-file) (Default)          
        - [Memcached](#configuration-memcached)
        - [Redis](#configuration-redis)
- [Cache Usage](#usage)
    - [Create A Cache Instance](#instance)
    - [Get Items](#get)
    - [Set Items](#set)
    - [Checking](#has)
    - [Delete Items](#delete)
    - [Clear the Cache](#clear)

<a name="introduction"></a>
## Introduction

Pletfix Cache System is just only an adapter for [Doctrine's Cache Provider](http://doctrine-orm.readthedocs.io/projects/doctrine-orm/en/latest/reference/caching.html), 
see also [Doctrine Cache on GitHub](https://github.com/doctrine/cache). 

<a name="configuration"></a>
### Configuration

The cache configuration is located at `config/cache.php`. In this file you may specify which cache driver you would like used by default throughout your application. 
The cache configuration file also contains various other options, which are documented within the file, so make sure to read over these options. 

Pletfix supports following popular cache driver:
- [APC](#configuration-apc)
- [Array](#configuration-array) 
- [File](#configuration-file) (Default)          
- [Memcached](#configuration-memcached)
- [Redis](#configuration-redis)
 
By default, Pletfix is configured to use the `file` cache driver, which stores the serialized, cached objects in the filesystem. 
For larger applications, it is recommended that you use a more robust driver such as Memcached or Redis. 
You may even configure multiple cache configurations for the same driver.

<a name="configuration-apc"></a>
#### APC

In order to use the APC cache driver you must have it compiled and enabled in your php.ini. 
You can read about APC in the [PHP Documentation](http://us2.php.net/apc). 
It will give you a little background information about what it is and how you can use it as well as how to install it.

There's nothing to configuration in `config/cache.php`.

<a name="configuration-array"></a>
#### Array

When using the Array Cache Driver, the cache does not persist between requests, but this is useful for testing in a testing environment.

There's nothing to configuration in `config/cache.php`.

<a name="configuration-file"></a>
#### File System

In the configuration file `config/cache.php` you can define where the cache files will be stored:

    'file' => [
        'driver' => 'file',
        'path'   => storage_path('cache/doctrine'),
    ],
        
<a name="configuration-memcached"></a>
#### Memcached

Using the Memcached driver requires the [Memcached PECL package](https://pecl.php.net/package/memcached) to be installed. 
You may list all of your Memcached servers in the `config/cache.php` configuration file:

    'memcached' => [
        'host' => '127.0.0.1',
        'port' => 11211,
        'weight' => 100
    ],

You may also set the `host` option to a UNIX socket path. If you do this, the `port` option should be set to `0`:

    'memcached' => [
        'host' => '/var/run/memcached/memcached.sock',
        'port' => 0,
        'weight' => 100
    ],

See [Memcached](https://memcached.org) for additional information.

<a name="configuration-redis"></a>
#### Redis

Before using a Redis cache, you will need to either install the `predis/predis` package (~1.0) via Composer or install the PhpRedis PHP extension via PECL.

For more information on configuring Redis, consult the [Redis Documentation](https://redis.io/documentation).

    'redis' => [
        'driver'  => 'redis',
        'host'    => env('REDIS_HOST', '127.0.0.1'),
        'port'    => env('REDIS_PORT', 6379),
        'timeout' => 0.0,
    ],
    
<a name="usage"></a>
## Cache Usage

<a name="instance"></a>
### Create A Cache Instance

The `Core\Services\CacheFactory` and `Core\Services\Cache` provide access to Pletfix's cache services. 
The `Factory` contract provides access to all cache drivers defined in `config/cache.php` for your application. 

However, you may also use the global `cache()` function to access the default cache store:

    $cache = cache();
    
You can set the driver name if you use an another driver as the default.
The driver name should correspond to one of the stores listed in the `stores` configuration array in your `cache` configuration file.
    
    $cache = cache('my-memcached-store');
    
> The `cache()` function is just a shortcut to get the cache store via the Cache Factory supported by Dependency Injector: 
>    
>       $cache = DI::getInstance()->get('cache-factory')->store('my-memcached-store');

Of course you may access various cache stores:

    $value = cache('file')->get('foo');
    cache('redis')->put('bar', $value);


<a name="get"></a>
### Get Items

The `get` method is used to retrieve items from the cache. If the item does not exist in the cache, `null` will be returned. 

    $value = cache()->get('key');

If you wish, you may pass a second argument to the `get` method specifying the default value you wish to be returned if the item doesn't exist:

    $value = cache()->get('key', 'default');

<a name="set"></a>
### Set Items

The `set` method may be used to store an item in the cache: 

    $value = cache()->set('key', 'foo');
        
You can set a lifetime in number of minutes if the entry entry should be expire:
         
    $value = cache()->set('key', 'foo', 60);
    
You can save any type of data whether it be a string, array, object, etc. 

    $value = cache()->set('my_array', [
        'key1' => 'value1',
        'key2' => 'value2',
    ]);

<a name="has"></a>
### Checking

The `has` method may be used to determine if an item exists in the cache:

    if (cache()->has('key')) {
        //
    }

<a name="delete"></a>
### Delete Items

You may remove items from the cache using the `delete` method:

    cache()->delete('key');

<a name="clear"></a>
### Clear the Cache

You may clear the entire cache using the `clear` method:

    cache()->clear();
