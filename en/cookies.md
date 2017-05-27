# Cookies

[Since 0.5.4]

- [Introduction](#introduction)
- [Create a Cache Instance](#instance)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

The Cookie Object is a very simple adapter of the [HTTP-Cookies](http://php.net/manual/en/features.cookies.php).

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note that cookies must be sent before any output from your script (this is a protocol restriction).

<a name="instance"></a>
## Create a Cookie

You may also use the `cookie()` function to access a cookie value:

    $cookie = cookie();
    
<a name="available-methods"></a>
## Available Methods

<div class="method-list" markdown="1">

[delete](#method-delete)
[get](#method-get)
[has](#method-has)
[set](#method-set)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-delete"></a>
#### `delete()` {.method .first-method}

You may remove a cookie using the `delete` method:

    cookie()->delete($name, $path, $domain);
    
 - `$path`: The path on the server in which the cookie will be available on.
    - If set to '/', the cookie will be available within the entire domain.
    - If set to '/foo/', the cookie will only be available within the /foo/ directory and all sub-directories such as 
      /foo/bar/ of domain.
    - The default value is the base directory of the application.
 - `$domain`: The (sub)domain that the cookie is available to.
    Setting this (such as 'example.com') will make the cookie available to that domain and all other
    sub-domains of it (i.e. www.example.com). The default is the current domain.

<a name="method-get"></a>
#### `get()` {.method}

The `get` method is used to get a cookie. If the item does not exist in the cache, `null` will be returned. 

    $value = cookie()->get('foo');

If you wish, you may pass a second argument to the `get` method specifying the default value you wish to be returned if 
the item doesn't exist:

    $value = cookie()->get('foo', 'default');

<a name="method-has"></a>
#### `has()` {.method}

The `has` method may be used to determine if an cookie exists:

    if (cookie()->has('foo')) {
        //
    }

<a name="method-set"></a>
#### `set()` {.method}

The `set` method may be used to send a cookie to the browser: 

    $value = cookie()->set('foo', 'bar', 1440);
       
The third argument is the time the cookie expires. If set to 0, or omitted, the cookie will expire when the browser 
closes.
             
> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, this value is stored on the clients computer; do not store sensitive information!

You can add a few more arguments, that are pass to PHP's native [setcookie](http://php.net/manual/en/function.setcookie.php) method:

    $value = cookie()->set($name, $value, $minutes, $path, $domain, $secure, $httpOnly);

 - `$path`: The path on the server in which the cookie will be available on.
    - If set to '/', the cookie will be available within the entire domain.
    - If set to '/foo/', the cookie will only be available within the /foo/ directory and all sub-directories such as 
      /foo/bar/ of domain.
    - The default value is the base directory of the application.
 - `$domain`: The (sub)domain that the cookie is available to.
    Setting this (such as 'example.com') will make the cookie available to that domain and all other
    sub-domains of it (i.e. www.example.com). The default is the current domain.
 - `$secure`: When set to TRUE, the cookie will only be set if a secure connection exists. The default is FALSE.
 - `$httpOnly`: When TRUE the cookie will be made accessible only through the HTTP protocol. The default is FALSE.
    