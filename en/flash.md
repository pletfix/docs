# Flash

[Since 0.5.3]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Basic Usage](#basic)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

Sometimes you may wish to store items in the session only for the next request. You may do so using the flash method. 
Flash data stored in the session will only be available during the subsequent HTTP request, and then will be deleted.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> For the flash functionality be sure, that the `ageFlash` bootstrap in enabled in `config/boot/bootstrap.php`:
>
>     (new Core\Bootstraps\AgeFlash)->boot();
>
> If you don't need flash, you may disable the `ageFlash` bootstrap for better performance.


<a name="configuration"></a>
## Configuration

Pletfix stores the flash data in the session under the `_flash` key. See the [Session]('session#configuration) chapter
for details about the session configuration. 


<a name="basic"></a>
## Basic Usage

### Get the Flash Instance

You can get an instance of the Flash from the Dependency Injector:

    /** @var \Core\Services\Contracts\Flash $flash */
    $flash = DI::getInstance()->get('flash');

You can also use the global `flash()` function to get the Flash instance, it is more comfortable:

    $flash = flash();

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, you can only write data to the cookie-based session as long as nothing has been sent to the browser.
> This also applies to the first read access, because the response header will be changed then.

<a name="get"></a>
### Get Flash Data

The `get` method reads the data from the flash:
 
    flash()->get('foo', 'default');

You can also use the global `flash()` function to get data from the flash directly:

    $flash = flash('foo', 'default');

<a name="set"></a>
### Set Flash Data

The `set` method writes the data to the flash:
 
    flash()->set('foo', $foo);
               
                       
<a name="available-methods"></a>
## Available Methods

The Flash object has these methods:

<div class="method-list" markdown="1">

[age](#method-age)
[clear](#method-clear)
[delete](#method-delete)
[get](#method-get)
[has](#method-has)
[merge](#method-merge)
[reflash](#method-reflash)
[set](#method-set)
[setNow](#method-set-now)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-age"></a>
#### `age()` {.method}	

To age the flash data for the session, you may use the `age` method:

    flash()->age();
    

<a name="method-clear"></a>
#### `clear()` {.method}

The `clear` method removes all items from the flash:

    flash()->clear();

See also [delete](#method-delete).

    
<a name="method-delete"></a>
#### `delete()` {.method}	

The `delete` method removes an entry from the flash:

    flash()->delete('key');
    
See also [clear](#method-clear).
    
    
<a name="method-get"></a>
#### `get()` {.method}	

The `get` method is used to retrieve items from the flash. If the item does not exist in the flash, `null` will be 
returned. 

    $value = flash()->get('key');


If you wish, you may pass a second argument to the `get` method specifying the default value you wish to be returned if 
the item doesn't exist:

    $value = flash()->get('key', 'default');
    
There is also a shortlier way to get a session value:
    
    $value = flash('key', 'default');
 
 
<a name="method-has"></a>
#### `has()` {.method}	

The `has` method may be used to determine if an item exists in the flash:

    if (flash()->has('key')) {
        //
    }
    
     
<a name="method-merge"></a>
#### `merge()` {.method}	

The `merge` method merges the given values to the flash:

    flash()->merge('errors', ['email' => 'It is not an email address!']);
    
    
<a name="method-reflash"></a>
#### `reflash()` {.method}	

If you need to keep your flash data for an additional request, you may use the `reflash` method:

    flash()->reflash(); // keeps all flash data
    
    flash()->reflash(['name', 'age', 'gender']);
    
    
<a name="method-set"></a>
#### `set()` {.method}	

The `set` method may be used to store an item in the flash:

    session()->set($key, $value);

The value is only be available during the subsequent HTTP request.
           
    
<a name="method-set-now"></a>
#### `setNow()` {.method}	

The `setNot` method flashes a value for immediate use:

    flash()->setNow('message', 'Operation was successfull!');
