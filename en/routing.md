# HTTP Routing

_Route a URI request to a controller action_

[Since 0.5.0]

- [Introduction](#introduction)
- [Usage](#usage)
	- [Accessing](#accessing)
	- [HTTP Method](#http-method)
	- [Route Parameters](#parameters)
	- [Route Name](#name)
	- [Middleware](#middleware)
	- [Caching](#caching)
	
	
<a name="introduction"></a>
## Introduction

<!--
	Slim Framework’s router is built on top of the [FastRoute](https://github.com/nikic/FastRoute) component, and it is remarkably fast and stable.
-->

The Route class represents an HTTP routing.

All web requests to a Pletfix application will be handled by the HTTP Router. 
The router will dispatch again the request to a function or controller action.

You can define the routes in `config/boot/routes.php`. 
As example, the Pletfix Application Skeleton have two route entries by default:

    $route = \Core\Application::route();
    
    $route->get('', 'HomeController@index');
    
    $route->get('test', function() {
    });

	
<a name="usage"></a>
## Usage

<a name="accessing"></a>	
### Accessing

You can get an instance of the HTTP Route directly from the Application:

    $route = \Core\Application::route();

The most basic Pletfix routes simply accept a URI and a Closure:

    $route->get('foo', function () {
        return 'Hello World';
    });

You can also route the request to a controller action. 

	$route->get('', 'HomeController@index');

The member function `index` of `\App\Controllers\HomeController` will receive the root request in the exmple above:

    class HelloController extends Controller
    {
        public function index()
        {
            return 'Hello World';
        }
    }
    
> You only need to specify the portion of the namespace that comes after the base \App\Controllers namespace.   
	
<a name="http-method"></a>	
### HTTP Method
	
The router allows you to register routes that respond to any HTTP verb:

    $route->get($uri, $callback);
	$route->head($uri, $callback);
    $route->post($uri, $callback);
    $route->put($uri, $callback);
    $route->patch($uri, $callback);
    $route->delete($uri, $callback);
	    
Sometimes you may need to register a route that responds to multiple HTTP verbs. 
You may do so using the `addRoute` method. 

    $route->addRoute(['GET', 'POST'], 'foo', function () {
        //
    });

Or, you may even register a route that responds to all HTTP verbs ('GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE') using the `any` method:
	
    $route->any('foo', function () {
        //
    });
	
If you wish to route a resource to a controller, you could use the `resource`function: 

	 $route->resource('photos', 'PhotoController');
	 
The example above will define the follwing route entries:

Verb      | URI                    | Action       | Route Name
----------|------------------------|--------------|---------------------
GET       | `/photos`              | index        | photos.index
GET       | `/photos/create`       | create       | photos.create
POST      | `/photos`              | store        | photos.store
GET       | `/photos/{photo}`      | show         | photos.show
GET       | `/photos/{photo}/edit` | edit         | photos.edit
PUT/PATCH | `/photos/{photo}`      | update       | photos.update
DELETE    | `/photos/{photo}`      | destroy      | photos.destroy
	
> A Note on HEAD Requests
>
> Source: <https://github.com/nikic/FastRoute>
> 
> The HTTP spec requires servers to [support both GET and HEAD methods](https://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.1.1):
> 
> The methods GET and HEAD MUST be supported by all general-purpose servers
> To avoid forcing users to manually register HEAD routes for each resource we fallback to matching an available GET route for a given resource. The PHP web SAPI transparently removes the entity body from HEAD responses so this behavior has no effect on the vast majority of users.
> 
> However, implementers using FastRoute outside the web SAPI environment (e.g. a custom server) MUST NOT send entity bodies generated in response to HEAD requests. If you are a non-SAPI user this is your responsibility; FastRoute has no purview to prevent you from breaking HTTP in such cases.
> 
> Finally, note that applications MAY always specify their own HEAD method route for a given resource to bypass this behavior entirely.	
	
	
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

Route parameters are always encased within `{}` braces and should consist of alphanumeric characters, minus (`-`), dot (`.`) and underscore (`_`).

#### Optional Parameters

Not supported yet, planned in future.

<!--
Occasionally you may need to specify a route parameter, but make the presence of that route parameter optional. 
You may do so by placing a `?` mark after the parameter name. Make sure to give the route's corresponding variable a default value:

    $route->get('user/{name?}', function ($name = null) {
        return $name;
    });

    $route->get('user/{name?}', function ($name = 'John') {
        return $name;
    });
-->

s. [Slim Framework](https://www.slimframework.com/docs/objects/router.html)
To make a section optional, simply wrap in square brackets:

	$route->get('/users[/{id}]', function ($id = null) {
		// responds to both `/users` and `/users/123`, but not to `/users/`
	});
	
Multiple optional parameters are supported by nesting:

	$route->get('/news[/{year}[/{month}]]', function ($year = null, $month = null) {
		// reponds to `/news`, `/news/2016` and `/news/2016/03`
	});	
	
Geplant ist die Möglichkeit wie bei [FastRoute](https://github.com/nikic/FastRoute):

Furthermore parts of the route enclosed in [...] are considered optional, so that /foo[bar] will match both /foo and /foobar. Optional parts are only supported in a trailing position, not in the middle of a route.

	// This route...
	$route->get('/user/{id:\d+}[/{name}]', $callback);
	// ...is equivalent to these two routes
	$route->get('/user/{id:\d+}', 'handler');
	$route->get('/user/{id:\d+}/{name}', $callback);

	// Multiple nested optional parts are possible as well
	$route->get('/user[/{id:\d+}[/{name}]]', $callback);

	// This route is NOT valid, because optional parts can only occur at the end
	$route->get('/user[/{id:\d+}]/{name}', $callback);

	
<a name="name"></a>	
### Route Name

Not supported yet, planned in future.

s. [Slim Framework](https://www.slimframework.com/docs/objects/router.html#route-names)

Application routes can be assigned a name. This is useful if you want to programmatically generate a URL to a specific route with the router’s `pathFor()` method. 
Each routing method described above returns a Route object, and this object exposes a `setName()` method.

	$app = new \Slim\App();
	$app->get('/hello/{name}', function ($request, $response, $args) {
		echo "Hello, " . $args['name'];
	})->setName('hello');
	
You can generate a URL for this named route with the application router’s `pathFor()` method.

	echo $app->getContainer()->get('router')->pathFor('hello', [
		'name' => 'Josh'
	]);
	// Outputs "/hello/Josh"
	
The router’s `pathFor()` method accepts two arguments:
- The route name
- Associative array of route pattern placeholders and replacement values	


<a name="middleware"></a>
### Middleware

Not supported yet, planned in future.

s.[Slim Framework](https://www.slimframework.com/docs/objects/router.html#route-middleware)
You can also attach middleware to any route or route group.

To assign middleware to a route, you have to only set the name of the middleware as third argument:

	$route->get('/', function () {
		// Uses Auth Middleware
	}, 'auth');

To set the the `middleware` for one or more routes, you have to use the `middleware`function:
	
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
	
It’s possible to enable router cache by setting valid filename in default settings:

s. [Slim Framework](https://www.slimframework.com/docs/objects/router.html#container-resolution)

- routerCacheFile
	Filename for caching the FastRoute routes. Must be set to to a valid filename within a writeable directory. 
	If the file does not exist, then it is created with the correct cache information on first run.
	Set to false to disable the FastRoute cache system. 
	(Default: false)	
	