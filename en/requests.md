# HTTP Requests

[Since 0.5.0]

- [Introduction](#introduction)
- [Accessing the HTTP Request](#accessing)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

The Request object is the current context for the HTTP Request.

<a name="accessing"></a>
## Accessing the HTTP Request

You can get an instance of the HTTP Request from the Dependency Injector:

    /** @var \Core\Services\Contracts\Request $request */
    $request = DI::getInstance()->get('request');
    $name = $request->input('name);
    
You can also use the global `request()` function to get the HTTP Request, it is more comfortable:
       
    $name = request()->input('name');


<a name="available-methods"></a>
## Available Methods

The Request object has these methods:

<div class="method-list" markdown="1">

[baseUrl](#method-base-url)
[body](#method-body)
[canonicalUrl](#method-canonical-url)
[cookie](#method-cookie)
[file](#method-file)
[fullUrl](#method-full-url)
[input](#method-input)
[ip](#method-ip)
[isAjax](#method-is-ajax)
[isJson](#method-is-json)
[isSecure](#method-is-secure)
[method](#method-method)
[path](#method-path)
[url](#method-url)
[wantsJson](#method-wants-json)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-base-url"></a>
#### `baseUrl()` {.method .first-method}

> This method based on the post ["Get the full URL in PHP"](http://stackoverflow.com/questions/6768793/get-the-full-url-in-php) at stackoverflow.    

The `baseUrl` gets the root URL for the application:

    echo request()->baseUrl();

    // https://www.example.com
    
> Notes:
> - This function does not include username:password from a full URL or the fragment (hash).
> - The host is lowercase as per RFC 952/2181.
> - It will not show the default port 80 for HTTP and port 443 for HTTPS.    

Im [Pletfix Application Skeleton](https://github.com/pletfix/app) wird die Base-URL über ein Meta-Tag bereitgestellt, da Sie auch clientseitig nützlich sein kann: 
  
    <meta name="base-url" content="{{ request()->baseUrl() }}"/>

Per JavaScript kann die Base-URL nun leicht ausgelesen werden:

    window.baseUrl = $('meta[name="base-url"]').attr('content').replace(/\/$/, '') + '/';

See also [canonicalUrl](#method-canonical-url), [fullUrl](#method-full-url) and [url](#method-url).


<a name="method-body"></a>
#### `body()` {.method}

The `body` method gets the raw HTTP request body of the request:

    echo request()->body();
    

<a name="method-canonical-url"></a>
#### `canonicalUrl()` {.method}

The `canonicalUrl` gets method the canonical URL for the request:

    //Example: fullUrl = "http://www.example.com/path?a=3"

    echo request()->canonicalUrl();

    // https://example.de/path
  
Der Unterschied zu `url()` ist, dass `canonicalUrl()` die Base-URL aus der Konfiguration `config('app.url')` ausliest 
und nur den Pfad aus dem Request übernimmt , während `url()` die URL ausschließlich aus der Anfrage des Browsers ermittelt.

`canonicalUrl()` liefert also für eine bestimmte Seite immer die selbe URL, selbst wenn die Seite über verschiedene URLs erreichbar ist.

> This URL is very important for SEO (Search Engine Optimizing), see the article 
> [Use canonical URLs](https://support.google.com/webmasters/answer/139066?hl=en) by Googles Help Forum for more details.

Über folgenden Verweis wird die Canonical URL für eine Seite festgelegt:
 
     <link rel="canonical" href="@yield('canonical-url', request()->canonicalUrl())"/>
     
See also [baseUrl](#method-base-url), [fullUrl](#method-full-url) and [url](#method-url).


<a name="method-cookie"></a>
#### `cookie()` {.method}

The `cookie` method retrieves a cookie from the request:

    echo request()->cookie($key, $default);
    

<a name="method-file"></a>
#### `file()` {.method}

The `file` method retrieves a file from the request:

    echo request()->file($key, $default);
    

<a name="method-full-url"></a>
#### `fullUrl()` {.method}

The `fullUrl` method gets the full [Uniform Resource Identifier](https://en.wikipedia.org/wiki/Uniform_Resource_Identifier) for the request:

    echo request()->fullUrl();

    // https://www.example.com/path?a=4
  
> Notes:
> - This function does not include username:password from a full URL or the fragment (hash).
> - The host is lowercase as per RFC 952/2181.
> - It will not show the default port 80 for HTTP and port 443 for HTTPS.
> - The #fragment_id is not sent to the server by the client (browser) and will not be added to the full URL.    

See also [baseUrl](#method-full-url), [canonicalUrl](#method-canonical-url) and [url](#method-url).


<a name="method-input"></a>
#### `input()` {.method}

The `input` method retrieves an input item from the request ($_GET and $_POST).:

    echo request()->input($key, $default);
    

<a name="method-ip"></a>
#### `ip()` {.method}

The `ip` method returns the client IP address:

    echo request()->ip();
    

<a name="method-is-ajax"></a>
#### `isAjax()` {.method}

The `isAjax` method determines if the request is the result of an AJAX call:

    echo request()->isAjax();
    

<a name="method-is-json"></a>
#### `isJson()` {.method}

The `isJson` method determines if the request is sending JSON:

    echo request()->isJson();
    
See also [wantsJson](#method-wants-json)


<a name="method-is-secure"></a>
#### `isSecure()` {.method}

The `isSecure` method checks whether the request is secure or not:

    echo request()->isSecure();
    

<a name="method-method"></a>
#### `method()` {.method}

> This method based on getMethod() at [Symfony's Request Object](https://github.com/symfony/http-foundation/blob/3.2/Request.php).

The `method` method gets the request method:

    echo request()->method();

    
The method is always an uppercase string: GET, HEAD, POST, PUT, PATCH or DELETE

If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method.

     
<a name="method-path"></a>
#### `path()` {.method}

The `path` method gets the path for the request without query string:

    // Example: fullUrl = "https://www.example.com/test?a=4"
    
    echo request()->path();

    // test
    

<a name="method-url"></a>
#### `url()` {.method}

The `url` method gets the the URL for the request without query string:

    echo request()->url();

    // https://www.example.com/path
  
See also [baseUrl](#method-base-url), [canonicalUrl](#method-canonical-url) and [fullUrl](#method-full-url).

    
<a name="method-wants-json"></a>
#### `wantsJson()` {.method}

The `wantsJson` method determines if the current request is asking for JSON in return:

    echo request()->wantsJson();
    
See also [isJson](#method-is-json)
