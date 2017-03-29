# Sessions

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.5.3

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Accessing the Session](#accessing)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction
 
Pletfix's session is an extension of the [PHP Session](http://php.net/manual/en/session.examples.basic.php). 

Pletfix starts the session automatically and ends it at soon as possible. Other scripts that share the same session 
are not blocked longer than necessary. 

See also the interesting blog post [https://ma.ttias.be/php-session-locking-prevent-sessions-blocking-in-requests/](PHP Session Locking) 
on the topic of ma.ttias.be.


<a name="configuration"></a>
## Configuration

Pletfix stores the session files in the `storage/sessions` directory by default. 
To configure the Pletfix Session, you should modify the `session` option in your `config/session.php` configuration file. 


<a name="accessing"></a>
## Accessing the Session

You can get an instance of the Session from the Dependency Injector:

    /** @var \Core\Services\Contracts\Session $session */
    $session = DI::getInstance()->get('session');

You can also use the global `session()` function to get the Session, it is more comfortable:

    $session = session();

> Note, you can only write data to the cookie-based session as long as nothing has been sent to the browser.
> This also applies to the first read access, because the response header will be changed then.

### Read Data

The `get` method reads the data from the session:
 
    session()->get('foo', 'default');

### Write Data

The `set` method writes the data to the session:
 
    session()->set('foo', $foo);
               
Write needs an exclusive lock for the session. Therefore, if the session was not started explicitly, the `set` method 
opens the session first and commits it immediately after writing so that other scripts do not block.
 
To prevent the session from being started and committed for every single write operation, you should start the session 
explicitly if several values are stored:
 
    session()
        ->start()
        ->set('foo', $foo)
        ->set('bar', $bar)
        ->commit();
 
However, you can also use a closure that start and commit the session for you:  
 
    session(function(Session $session) use ($foo, $bar) {
        $session->set('foo', $foo);
        $session->set('bar', $bar);
    });
               
    
<a name="available-methods"></a>
## Available Methods

The Session object has these methods:

<div class="method-list" markdown="1">

[abort](#method-abort)
[clear](#method-clear)
[commit](#method-commit)
[csrf](#method-csrf)
[delete](#method-delete)
[flash](#method-flash)
[get](#method-get)
[isStarted](#method-is-started)
[has](#method-has)
[kill](#method-kill)
[lock](#method-lock)
[reflash](#method-reflash)
[regenerate](#method-regenerate)
[set](#method-set)
[start](#method-start)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-abort"></a>
#### `abort()` {.method}

The `cancel` discards the changes made during the current request.

    session()->cancel();

This function calls `session_abort()` internally.

See also [delete](#method-delete).


<a name="method-clear"></a>
#### `clear()` {.method}

The `clear` method removes all items from the session:

    session()->clear();

See also [delete](#method-delete).


<a name="method-commit"></a>
#### `commit()` {.method}	

To save the session data and end its use during the current request, call the `commit` method:

    session()->commit();
    
> The Session will automatically commit the changes when PHP is finished executing a script.


<a name="method-csrf"></a>
#### `csrf()` {.method}	

The `csrf` method gets a [CSRF token value](https://en.wikipedia.org/wiki/Cross-site_request_forgery):

    echo session()->csrf();
    
    
<a name="method-delete"></a>
#### `delete()` {.method}	

The `delete` method removes an entry from the session:

    session()->delete('key');
    
See also [clear](#method-clear).
    
    
<a name="method-flash"></a>
#### `flash()` {.method}	

Sometimes you may wish to store items in the session only for the next request. You may do so using the flash method. 
Data stored in the session using this method will only be available during the subsequent HTTP request, and then will 
be deleted:

    session()->flash('key', Operation was successfull!');
    
See also [reflash](#method-reflash).
    
    
<a name="method-get"></a>
#### `get()` {.method}	

The `get` method is used to retrieve items from the sesion. If the item does not exist in the session, `null` will be 
returned. 

    $value = session()->get('key');

If you wish, you may pass a second argument to the `get` method specifying the default value you wish to be returned if 
the item doesn't exist:

    $value = session()->get('key', 'default');
    
There is also a shortlier way to get a session value:
    
     session('key', 'default');
 
 
<a name="method-has"></a>
#### `has()` {.method}	

The `has` method may be used to determine if an item exists in the session:

    if (session()->has('key')) {
        //
    }
    
    
<a name="method-is-started"></a>
#### `isStarted()` {.method}	

The `isStarted` method determines if the session is started and therefore writable. 

    $isStarted = session()->isStarted(); 


<a name="method-kill"></a>
#### `kill()` {.method}	

The `kill` method removes the session completely (both values as well as session cookie).
    
    session()->kill(); 
    
    
<a name="method-lock"></a>
#### `lock()` {.method}	

This method will pass a closure for writing session data. The session is started and committed automatically.
    
See also [flash](#method-flash).

    session()->lock(function(Session $session) use ($foo, $bar) {
        $session->set('foo', $foo);
        $session->set('bar', $bar);
    });

    
<a name="method-reflash"></a>
#### `reflash()` {.method}	

If you need to keep your flash data for an additional request, you may use the `reflash` method:

    session()->reflash(); // keeps all flash data
    
    session()->reflash(['name', 'age', 'gender']);
    
See also [flash](#method-flash).
    
    
<a name="method-regenerate"></a>
#### `regenerate()` {.method}	

Any time a user has a change in privilege be sure to regenerate the session id:

    session()->regenerate();
    
> The `regenerate()` method also regenerates the CSRF token value.
    
        
<a name="method-set"></a>
#### `set()` {.method}	

The `set` method may be used to store an item in the session: 

    session()->set($key, $value);
        

<a name="method-start"></a>
#### `start()` {.method}	

The `set` method starts new or resume existing session: 

    session()->start();
        
   