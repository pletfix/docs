# Cache

[Since 0.5.0]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Create a Cache Instance](#instance)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

Pletfix Cache System is just an adapter for [Doctrine's Cache Provider](http://doctrine-orm.readthedocs.io/projects/doctrine-orm/en/latest/reference/caching.html), 
licensed under [MIT License](https://github.com/doctrine/cache/blob/master/LICENSE). 
See also [Doctrine Cache on GitHub](https://github.com/doctrine/cache). 

<a name="configuration"></a>
## Configuration

The cache configuration is located at `config/cache.php`. In this file you may specify which cache driver you would like 
to be used by default throughout your application. The cache configuration file also contains various other options, 
which are documented within the file, so make sure to read over these options. 

Pletfix supports following popular cache driver:
- [APCu](#configuration-apcu)
- [Array](#configuration-array) 
- [File](#configuration-file)          
- [Memcached](#configuration-memcached)
- [Redis](#configuration-redis)
 
By default, Pletfix is configured to use the `file` cache driver, which stores the serialized, cached objects in the 
filesystem. For larger applications, it is recommended that you use a more robust driver such as Memcached or Redis. 
You may even configure multiple cache configurations for the same driver.

<a name="configuration-apcu"></a>
### APCu

In order to use the APCu cache driver you must have it compiled and enabled in your php.ini. 
You can read about APCu in the [PHP Documentation](http://us2.php.net/apc). 
It will give you a little background information about what it is and how you can use it as well as how to install it.

There's nothing to configuration in `config/cache.php`.

<a name="configuration-array"></a>
### Array

When using the Array Cache Driver, the cache does not persist between requests, but this is useful for testing in a 
testing environment.

There's nothing to configurate in `config/cache.php`.

<a name="configuration-file"></a>
### File System

In the configuration file `config/cache.php` you can define where the cache files will be stored:

    'file' => [
        'driver' => 'file',
        'path'   => storage_path('cache/doctrine'),
    ],
        
<a name="configuration-memcached"></a>
### Memcached

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
### Redis

Before using a Redis cache, you will need to either install the `predis/predis` package (~1.0) via Composer or install 
the [PhpRedis PHP extension](https://github.com/phpredis/phpredis) via PECL.

For more information on configuring Redis, consult the [Redis Documentation](https://redis.io/documentation).

    'redis' => [
        'driver'  => 'redis',
        'host'    => env('REDIS_HOST', '127.0.0.1'),
        'port'    => env('REDIS_PORT', 6379),
        'timeout' => 0.0,
    ],
    
<a name="instance"></a>
## Create a Cache Instance

You may use the `cache()` function to access the default cache store:

    $cache = cache();
    
You can set the store name if you use another store as the default. The store name should be listed in the `stores` 
configuration array in your `cache` configuration file:
    
    $cache = cache('my-memcached-store');
    
> The `cache()` function is just a shortcut to get the `Cache` instance via the `CacheFactory` supported by 
> [Dependency Injector](di): 
>    
>       $cache = DI::getInstance()->get('cache-factory')->store($store);

Of course you may access various cache stores:

    $value = cache('file')->get('foo');
    cache('redis')->put('bar', $value);

<a name="available-methods"></a>
## Available Methods

<div class="method-list" markdown="1">

[clear](#method-clear)
[delete](#method-delete)
[get](#method-get)
[has](#method-has)
[set](#method-set)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-clear"></a>
#### `clear()` {.method .first-method}

You may clear the entire cache using the `clear` method:

    cache()->clear();

<a name="method-delete"></a>
#### `delete()` {.method}

You may remove items from the cache using the `delete` method:

    cache()->delete('key');

<a name="method-get"></a>
#### `get()` {.method}

The `get` method is used to retrieve items from the cache. If the item does not exist in the cache, `null` will be 
returned. 

    $value = cache()->get('key');

If you wish, you may pass a second argument to the `get` method specifying the default value you wish to be returned if 
the item doesn't exist:

    $value = cache()->get('key', 'default');

<a name="method-has"></a>
#### `has()` {.method}

The `has` method may be used to determine if an item exists in the cache:

    if (cache()->has('key')) {
        //
    }

<a name="method-set"></a>
#### `set()` {.method}

The `set` method may be used to store an item into the cache: 

    $value = cache()->set('key', 'foo');
    
If a cache entry with the given id already exists, its data will be replaced.    
        
You can set a lifetime in number of minutes if the entry should be expire:
         
    $value = cache()->set('key', 'foo', 60);

If the lifetime is equal zero (the default), the entry never expires (although it may be deleted from the cache to make 
place for other entries).
    
You can save any type of data whether it is a string, array, object, etc. 

    $value = cache()->set('my_array', [
        'key1' => 'value1',
        'key2' => 'value2',
    ]);