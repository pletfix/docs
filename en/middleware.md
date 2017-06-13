# Middleware

[Since 0.5.0]

- [Introduction](#introduction)
- [Writing Middleware](#writing)
- [Invoke Middleware](#routes)

<a name="introduction"></a>
## Introduction

You can run middleware before and after your Pletfix application to manipulate the Request and Response objects as you 
see fit. A typical use case for a middleware is the user authentication or a CSRF check.


<a name="writing"></a>
## Writing Middleware

A good place to store the Middleware is the `app/Middleware` directory.

Below is an example of a simple middleware class. 

    class Example implements MiddlewareContract
    {
        public function process(Request $request, Delegate $delegate)
        {
            // Modify the request or do something else before invoking the next middleware...
            
            $response = $delegate->process($request);

            // Modify the response or do something else after invoking... 
    
            return $response;
        }
    }
    
You may also add arguments if need it:    

    public function process(Request $request, Delegate $delegate, $argument = null)
    {
        // ...
    }


<a name="routes"></a>
### Invoke Middleware

You can add the middleware to a route. Read [here](routing#middleware) to learn how to do it.
