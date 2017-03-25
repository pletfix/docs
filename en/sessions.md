# Sessions

_Preserve certain data across subsequent accesses._

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.5.3

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Accessing the Session](#accessing)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

The Session Object is an adapter of the [PHP Session](http://php.net/manual/en/session.examples.basic.php).

<a name="configuration"></a>
## Configuration

Pletfix stores the session files in the `storage/sessions` directory by default. 
To configure the Pletfix Session, you should modify the `session` option in your `config/app.php` configuration file: 

    'session' => [
        'name'     => env('SESSION_NAME', 'pletfix'),
        'lifetime' => env('SESSION_LIFETIME', '30'),
        'path'     => storage('sessions'),
    ],
    
    
<a name="accessing"></a>
## Accessing the Session

You can get an instance of the Session from the Dependency Injector:

    /** @var \Core\Services\Contracts\Session $session */
    $session = DI::getInstance()->get('session');
    $name = $session->get('name');
    
You can also use the global `session()` function to get the Session, it is more comfortable:
       
    $name = session()->get('name');

    
<a name="available-methods"></a>
## Available Methods

The Session object has these methods:

<div class="method-list" markdown="1">

[all](#method-all)
[clear](#method-clear)
[csrf](#method-csrf)
[delete](#method-delete)
[flash](#method-flash)
[get](#method-get)
[has](#method-has)
[lifetime](#method-lifetime)
[reflash](#method-reflash)
[regenerate](#method-regenerate)
[save](#method-save)
[set](#method-set)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-all"></a>
#### `all()` {.method .first-method}

The `all` method gets all session items:

    echo session()->all();


<a name="method-clear"></a>
#### `clear()` {.method}

The `clear` method removes all items from the session:

    echo session()->clear();

See also [delete](#method-delete).


<a name="method-csrf"></a>
#### `csrf()` {.method}	

The `csrf` method gets a [CSRF token value](https://en.wikipedia.org/wiki/Cross-site_request_forgery):

    echo session()->csrf();
    
    
<a name="method-delete"></a>
#### `delete()` {.method}	

The `delete` method removes an entry from the session:

    echo session()->delete('key');
    
See also [clear](#method-clear).
    
    
<a name="method-flash"></a>
#### `flash()` {.method}	

Sometimes you may wish to store items in the session only for the next request. You may do so using the flash method. 
Data stored in the session using this method will only be available during the subsequent HTTP request, and then will 
be deleted:

    echo session()->flash('Operation was successfull!');
    
See also [reflash](#method-reflash).
    
    
<a name="method-get"></a>
#### `get()` {.method}	

The `get` method is used to retrieve items from the sesion. If the item does not exist in the session, `null` will be 
returned. 

    $value = session()->get('key');

If you wish, you may pass a second argument to the `get` method specifying the default value you wish to be returned if 
the item doesn't exist:

    $value = session()->get('key', 'default');
    
    
<a name="method-has"></a>
#### `has()` {.method}	

The `has` method may be used to determine if an item exists in the session:

    if (session()->has('key')) {
        //
    }
    
    
<a name="method-lifetime"></a>
#### `lifetime()` {.method}	

We can set the session lifetime in minutes using the `lifetime` function. 

    echo session()->lifetime(1440); // one day
    
    
<a name="method-reflash"></a>
#### `reflash()` {.method}	

If you need to keep your flash data for an additional request, you may use the `reflash` method:

    echo session()->reflash(); // keeps all flash data
    
    echo session()->reflash(['name', 'age', 'gender']);
    
See also [flash](#method-flash).
    
    
<a name="method-regenerate"></a>
#### `regenerate()` {.method}	

Any time a user has a change in privilege be sure to regenerate the session ID:

    echo session()->regenerate();
    
> The `regenerate()` method also regenerates the CSRF token value.
    
    
<a name="method-save"></a>
#### `save()` {.method}	

To save the session data and end its use during the current request, call the save() method:

    echo session()->save();
    
> Normally you do not need to call the save() method explicitly because the Session will automatically save the items 
when PHP is finished executing a script.

    
<a name="method-set"></a>
#### `set()` {.method}	

The `set` method may be used to store an item in the session: 

    echo session()->set();
        
   