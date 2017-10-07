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

[back](#method-back)
[cache](#method-cache)
[clear](#method-clear)
[getContent](#method-get-content)
[getHeader](#method-get-header)
[getStatusCode](#method-get-status-code)
[getStatusText](#method-get-status-test)
[header](#method-header)
[json](#method-json)
[output](#method-output)
[plaintext](#method-plaintext)
[redirect](#method-redirect)
[send](#method-send)
[status](#method-status)
[view](#method-view)
[withFlash](#method-with-flash)
[withInput](#method-with-input)
[withMessage](#method-with-message)
[withError](#method-with-error)
[withErrors](#method-with-errors)
[write](#method-write)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-back"></a>
#### `back()` {.method .first-method}

The `back` method gets a redirect to the previous page on which the user clicked a link to the current page.

    return response()->back();
    
You can specify a fallback url that is used if the HTTP_REFERER is not set in the request header because the user did 
not clicked a link before: 
     
    return response()->back('home');         

See also the [redirect](responses#method-redirect) method.


<a name="method-cache"></a>
#### `cache()` {.method}

The `cache` sets caching headers for the response:

    response()->cache(false); // no-cache
    
    response()->cache('2017-02-25 00:00:00);
    
    
<a name="method-clear"></a>
#### `clear()` {.method}

The `clear` method clears the response:

    response()->clear();
        

<a name="method-get-content"></a>
#### `getContent()` {.method}

The `getContent` method returns the content from the response:

    $content = response()->getContent();
            
            
<a name="method-get-header"></a>
#### `getHeader()` {.method}

The `getHeader` method returns the header from the response:

    $header = response()->getHeader();

    $url = response()->getHeader('location');
        
        
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
         
         
<a name="method-json"></a>
#### `json()` {.method}

The `json` method gets a JSON response:

    return response()->json($data);         


<a name="method-download"></a>
#### `download()` {.method}

The `download` method gets a file download response:

    return response()->download($pathToFile);
        
You may set a file name as the second argument that is seen by the user downloading the file: 

    return response()->download($pathToFile, $name);

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>   
> If you like to display the file directly in the browser, use the [file](#method-file) method instead.


<a name="method-file"></a>
#### `file()` {.method}

The `file` method gets the raw contents of a binary file. It may be used to display a file, such as an image or PDF, 
directly in the user's browser instead of initiating a download.

    return response()->file($pathToFile);
   
> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>        
> If you like initiating a download, use the [download](#method-download) method instead.         
     
        
<a name="method-output"></a>
#### `output()` {.method}

The `output` method sets the output:

    echo response()->output('foo');          
     
You can set the response's status and headers as like as:

    return response()->output('foo, ['a' => 4711], 200, ['Content-Type' => 'text/plain']);   
        
<a name="method-plaintext"></a>
#### `plaintext()` {.method}

The `plaintext` method gets a plaintext response:

    return response()->plaintext('Hello World!);  
              

<a name="method-redirect"></a>
#### `redirect()` {.method}

The `redirect` method returns a redirect HTTP response to the given URL:
    
    $redirect = response()->redirect(url('home'));
     
The default HTTP status is 302 for a temporarily link. You can create a permanently redirekt like this:

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

    response()->status(Response::HTTP_NOT_FOUND);     
    
    
<a name="method-view"></a>
#### `view()` {.method}

The `view` method renders the output by the given view:

    return response()->view($name);   

If you need control over the response's status and headers but also need to return a view as the response's content, you should use the `view` method:

    return response()->view($name, $variables = [], 200, ['Content-Type' => 'text/plain']);   
       
Of course, if you do not need to pass a custom HTTP status code or custom headers, you should use the global `view` helper function:
       
    return view($name);   
    
    
<a name="method-with-flash"></a>
#### `withFlash()` {.method}

The `withFlash` method flashes a piece of data to the session:

    return response()->withFlash('foo', 'bar');   

An array is not overridden but merged with the flash data:

    return response()
        ->withFlash('foo', ['bar', 'baz'])
        ->withFlash('foo', ['boo']); // foo = ['bar', 'baz', 'boo']   
 
 
<a name="method-with-input"></a>
#### `withInput()` {.method}

The `withInput` method flashes an array of input to the session:

    return response()->withInput($input);   

You may omit the argument to flash all of the current input:

    return response()->withInput();   

Use the [old() function](helpers#method-old) during the subsequent HTTP request to retrieve the input from 
the flash:
    
    $email = old('email);


<a name="method-with-message"></a>
#### `withMessage()` {.method}

The `withMessage` method flashes a message to the session:

    return response()->withMessage('Operation successfull.');

Use the [message() function](helpers#method-message) during the subsequent HTTP request to retrieve the message from 
the flash:
    
    $message = message();
    

<a name="method-with-error"></a>
#### `withError()` {.method}

The `withError` method flashes an error message to the session:

    return response()->withError('Operation failed.');   
    
If the error is related to a input field, you may set the fields name as second argument:

    return response()->withError('The e-mail is invalid.', 'email');   
          
Use the [error() function](helpers#method-error) during the subsequent HTTP request to retrieve the error message from 
the flash:
    
    $error = error('email');
    
    
<a name="method-with-errors"></a>
#### `withErrors()` {.method}

The `withErrors` method flashes a list of error messages to the session:

    return response()->withErrors([
        'email'    => 'The e-mail is invalid.',
        'password' => 'The password is required.',
    ]);   

Use the [error() function](helpers#method-error) during the subsequent HTTP request to retrieve the error message from 
the flash:
    
    $error = error();

     
<a name="method-write"></a>
#### `write()` {.method}

The `write` method contents to the response body:

    return response()->write('foo');   
     