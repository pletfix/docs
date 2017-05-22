# HTTP Responses

_Response to be returned_

[Since 0.5.0]

- [Introduction](#introduction)
- [Creating HTTP Responses](#creating)
- [Available Methods](#available-methods)

> The Pletfix HTTP Response class based on [Flight, an extensible micro-framework](https://github.com/mikecao/flight/blob/master/flight/net/Response.php).
> It's open-sourced software licensed under the [MIT license](https://github.com/mikecao/flight/blob/master/LICENSE).
 
<a name="introduction"></a>
## Introduction

The Response class represents an HTTP response. The object contains the response headers, HTTP status code, and response body.

<a name="creating"></a>
## Creating HTTP Responses

All routes and controllers should return a response to be sent back to the user's browser. 

The simplest way to return responses is returning a string from a route or controller:

    $route->get('hello', function () {
        return 'Hello World';
    });

The framework will automatically convert the string into a full HTTP response.

Another way is returning a full `Response` instance directly from a route or controller. 
You can create a `Response` instance via Dependency Injector: 

    $route->get('hello', function () {
        /** @var \Core\Services\Contracts\Response $response */
        $response = DI::getInstance()->get('response');
        return $response->output('Hello World');
    });

The shortcut is the global function `response()` to creating a Response instance: 

    $route->get('hello', function () {
        return response()->output('Hello World');
    });

Returning a full `Response` instance allows you to customize the response's HTTP status code and headers: 

    $route->get('hello', function () {
        return response->output('Hello World', 200, ['Content-Type' => 'text/plain']);
    });


<a name="available-methods"></a>
## Available Methods

The Response object has these methods:

<div class="method-list" markdown="1">

[cache](#method-cache)
[clear](#method-clear)
[getHeaders](#method-get-headers)
[getStatusCode](#method-get-status-code)
[getStatusText](#method-get-status-test)
[header](#method-header)
[output](#method-output)
[redirect](#method-redirect)
[send](#method-send)
[status](#method-status)
[view](#method-view)
[write](#method-write)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-cache"></a>
#### `cache()` {.method .first-method}

The `cache` sets caching headers for the response:

    response()->cache();
    
    response()->cache('2017-02-25 00:00:00);
    
    
<a name="method-clear"></a>
#### `clear()` {.method}

The `clear` method clears the response:

    response()->clear();
        
        
<a name="method-get-headers"></a>
#### `getHeaders()` {.method}

The `getHeaders` method returns the headers from the response:

    $headers = response()->getHeaders();
        
        
<a name="method-get-status-code"></a>
#### `getStatusCode()` {.method}

The `getStatusCode` method gets the HTTP status code:

    echo response()->getStatusCode();
        
            
<a name="method-get-status-text"></a>
#### `getStatusText()` {.method}

The `getStatusText` gets the HTTP status text:

    echo response()->getStatusText();
    
    
<a name="method-header"></a>
#### `header()` {.method}

The `header` method adds a header to the response:

    return response()->output($content)
                ->header('Content-Type', $type)
                ->header('X-Header-One', 'Header Value')
                ->header('X-Header-Two', 'Header Value');
        
        
<a name="method-output"></a>
#### `output()` {.method}

The `output` method sets the output:

    echo response()->output('foo');          
     
You can set the response's status and headers as like as:

    return response()->output('foo, ['a' => 4711], 200, ['Content-Type' => 'text/plain']);   
        

<a name="method-redirect"></a>
#### `redirect()` {.method}

The `redirect` method returns a redirect HTTP response to the given URL:
    
    $redirect = response()->redirect(url('home'));
     
The default HTTP status is 302 for a non-permanently link. You can create a permanently redirekt like this:

    $redirect = response()->redirect(url('home'), 301);   
  
> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>    
> Note, there is also [helper function](helpers#redirect) to create a redirect response:
>
>    $redirect = redirect('home');
   
      
<a name="method-send"></a>
#### `send()` {.method}

Sends a HTTP response:

    response()->send();   
      
> Fhe Framework will execute this method automatically, so you don't call this method explicitly!    
    
    
<a name="method-status"></a>
#### `status()` {.method}

The `status` method sets the HTTP status code:

    response()->status(HTTP_STATUS_NOT_FOUND);     
    
    
<a name="method-view"></a>
#### `view()` {.method}

The `view` method gets the evaluated view contents for the given view:

    return response()->view($name);   

If you need control over the response's status and headers but also need to return a view as the response's content, you should use the `view` method:

    return response()->view($name, $variables = [], 200, ['Content-Type' => 'text/plain']);   
       
Of course, if you do not need to pass a custom HTTP status code or custom headers, you should use the global `view` helper function:
       
    return view($name);   
       
    
<a name="method-write"></a>
#### `write()` {.method}

The `write` method contents to the response body:

    return response()->write('foo');   
     