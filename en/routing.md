# HTTP Routing

_Route a URI request to a controller action_

[Since 0.5.0]

- [Introduction](#introduction)
- [Defining Routes](#defining)
	- [Accessing](#accessing)
	- [Route Handler](#handler)	
	- [HTTP Method](#http-method)
	- [Route Parameters](#parameters)
	- [Named Routes](#name)
	- [Middleware](#middleware)
- [Caching](#caching)
	
	
<a name="introduction"></a>
## Introduction

The Route class represents an HTTP routing.

It was inspirated by the Router of [Slim Framework](https://www.slimframework.com/docs/objects/router.html) 
which built on top of the [FastRoute](https://github.com/nikic/FastRoute) component.
The idea for the syntax of optional parameters was adopted by [Laravel](https://laravel.com/docs/5.4/routing#parameters-optional-parameters).

All web requests to a Pletfix application will be handled by the HTTP Router. 
The router will dispatch again the request to a function or controller action.


<a name="defining"></a>
## Defining Routes

You can create the routing table in `config/boot/routes.php`. 
As example, the [Pletfix Application Skeleton](https://github.com/pletfix/app) have two route entries by default:

    $route = \Core\Application::route();
    
    $route->get('', 'HomeController@index');
    
    $route->get('test', function() {
    });
	
	
<a name="accessing"></a>	
### Accessing

As you can see in the example above, you get an instance of the HTTP Route directly from the Application:

    $route = \Core\Application::route();

	
<a name="handler"></a>	
### Route Handler
	
The most basic Pletfix routes simply accept a URI and a Closure:

    $route->get('foo', function () {
        return 'Hello World';
    });

You can also route the request to a [controller](controllers) action: 

	$route->get('', 'HomeController@index');

The member function `index` of `\App\Controllers\HomeController` will receive the root request in the example above:

    class HomeController extends Controller
    {
        public function index()
        {
            return 'Hello World';
        }
    }
    
> You only need to specify the portion of the namespace that comes after the base `\App\Controllers` namespace.   
> So, if your controller class is `App\Controllers\Admin\UserController`, you should register routes to the 
> controller like this:
>
>       $route->get('users/{id}', 'Admin\UserController@show');
	
	
<a name="http-method"></a>	
### HTTP Method
	
The router allows you to register routes that respond to any HTTP verb:

    $route->get($uri, $callback);
	$route->head($uri, $callback);
    $route->post($uri, $callback);
    $route->put($uri, $callback);
    $route->patch($uri, $callback);
    $route->delete($uri, $callback);
	$route->options($uri, $callback);
	    
Sometimes you may need to register a route that responds to multiple HTTP verbs. 
You may do so using the `multi` method. 

    $route->multi(['GET', 'POST'], 'foo', function () {
        //
    });

Or, you may even register a route that responds to all HTTP verbs ('GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE') 
using the `any` method:
	
    $route->any('foo', function () {
        //
    });
	
If you wish to route a resource to a [CRUD controller](controllers#resource), you could use the `resource`function: 

	 $route->resource('photos', 'PhotoController');
	 
The example above will define the follwing route entries:

HTTP Method | Path                | Action       | Route Name     | Used for
------------|---------------------|--------------|----------------|---------------------------------------------
GET         | `/photos`           | index        | photos.index	  | Display a list of all photos.
GET         | `/photos/create`    | create       | photos.create  | Return an HTML form for creating a new photo.
POST        | `/photos`           | store        | photos.store   | Store a new photo.
GET         | `/photos/{id}`      | show         | photos.show    | Display a specific photo.
GET         | `/photos/{id}/edit` | edit         | photos.edit    | Return an HTML form for editing a photo.
PUT/PATCH   | `/photos/{id}`      | update       | photos.update  | Update a specific photo.
DELETE      | `/photos/{id}`      | destroy      | photos.destroy | Delete a specific photo.


> **What is the HTTP OPTIONS method?**
>
> To quote the spec: 
> _"This method allows the client to determine the options and/or requirements associated with a resource, or the 
> capabilities of a server, without implying a resource action or initiating a resource retrieval."_
> ([HTTP RFC 2616 Specification, 9.2](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html)). 
>
> Minimally, the response should be a 200 OK and have an Allow header with a list of HTTP methods that may be used on 
> this resource. As an authorized user on an API, if you were to request OPTIONS /users/me, you should receive something 
> like:
>
>     200 OK
>     Allow: HEAD,GET,PUT,DELETE,OPTIONS
>
> Source: <http://zacstewart.com/2012/04/14/http-options-method.html> by Zac Stewart

> **A Note on HTTP HEAD method**
>
> To quote the spec ones more: 
> - _"The methods GET and HEAD MUST be supported by all general-purpose servers. All other methods are OPTIONAL."_ 
> ([HTTP RFC 2616 Specification, 5.1.1](https://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.1.1)) 
> - _"The HEAD method is identical to GET except that the server MUST NOT return a message-body in the response."_ 
> ([HTTP RFC 2616 Specification, 9.4](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html))
>
> To avoid forcing users to manually register HEAD routes for each resource we fallback to matching an available GET 
> route for a given resource. If you wish - for whatever reason - to define a route explicitly for the HEAD method, 
> define this after the GET route to override the default.
	
<a name="parameters"></a>	
### Route Parameters

#### Required Parameters

You may capture segments of the URI within your route by defining route parameters:

    $route->get('user/{id}', function ($id) {
        return 'User '.$id;
    });

You may define as many route parameters as required by your route:

    $route->get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
        //
    });

Route parameters are always encased within `{}` braces and should consist of alphanumeric characters, minus (`-`), 
dot (`.`) and underscore (`_`).

#### Optional Parameters

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.9.6

To make a segment optional, simply add a `?` mark after the parameter name: 
	
	$route->get('/users/{id?}', function ($id = null) {
		// responds to both `/users` and `/users/123`, but not to `/users/`
	});

---	
**Possible alternative solution 2 - I'm still not sure which solution I'll choose.**
	
To make a segment optional, simply wrap in square brackets:

	$route->get('/users[/{id}]', function ($id = null) {
		// responds to both `/users` and `/users/123`, but not to `/users/`
	});
	
Multiple optional parameters are supported by nesting:

	$route->get('/news[/{year}[/{month}]]', function ($year = null, $month = null) {
		// reponds to `/news`, `/news/2016` and `/news/2016/03`
	});	
	
Optional parts are only supported in a trailing position, not in the middle of a route. As example this route is NOT valid:

	$route->get('/user[/{id:\d+}]/{name}', $callback);
---
	
	
<a name="name"></a>	
### Named Routes

Not supported yet, planned in future.

Application routes can be assigned a name. This is useful if you want to programmatically generate a URL to a specific 
route.
 
Each [routing method](#http-method) described above returns a `Route` object, and this object exposes a `setName()` method.

	$route->get('/hello/{name}', function ($name) {
		echo "Hello, " . $name;
	})->setName('hello');
	
You can generate a URL for this named route with the `route()` helper function.

	echo route('hello', ['name' => 'Josh']);
	
	// Outputs "/hello/Josh"
	

<a name="middleware"></a>
### Middleware

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.7.0	

You can also attach middleware to any route or route group.

To assign middleware to a route, use the `setMiddleware()` function like this:

	$route->get('/', function () {
		// Uses Auth Middleware
	})->setMiddleware('auth');

To set the the middleware for one or more routes, you also could use the `middleware` function:
	
    $route->middleware('auth', function () {
        $route->get('/', function ()    {
            // Uses Auth Middleware
        });

        $route->get('user/profile', function () {
            // Uses Auth Middleware
        });
    });
	

<a name="caching"></a>
### Route Caching
	
<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.5.7	
	
It’s possible to enable router cache in the `config/app.php` configuration file:

	'router_cache' => true,

The default ist false. 
	
Note that Closure based routes cannot be cached. To use route caching, you must convert any Closure routes to controller 
classes!
