# Controllers

[Since 0.5.0]

TODO: Anpassen 

- [Introduction](#introduction)
- [Basic Controllers](#basic)
- [Resource Controllers](#resource)

<a name="introduction"></a>
## Introduction

Instead of defining all of your request handling logic as Closures in route files, you may wish to organize this 
behavior using Controller classes. Controllers can group related request handling logic into a single class. 
Controllers are stored in the `app/Controllers` directory.

<a name="basic"></a>
## Basic Controllers

Below is an example of a basic controller class. 
Note that the controller is only a simple class and does not need to extend a contract.

    class UserController
    {
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
         */
        public function show($id)
        {
            return view('user.profile', ['user' => User::findOrFail($id)]);
        }
    }

<a name="routes"></a>
### Routes

You can define a [route](routing) to this controller action like so:

    $route->get('users/{id}', 'UserController@show');

Now, when a request matches the specified route URI, the `show` method on the `UserController` class will be executed. 

> <i class="fa fa-info fa-2x" aria-hidden="true"></i>
> You only need to specify the portion of the namespace that comes after the base `\App\Controllers` namespace. 
> So, if your controller class is `App\Controllers\Admin\UserController`, you should register routes to the 
> controller like this:
>
>       $route->get('users/{id}', 'Admin\UserController@show');


<a name="resource"></a>
## Resource Controllers

You may register a [resourceful route](routing) to a controller:

    $route->resource('articles', 'ArticleController');

This routes allows to perform the four basic "CRUD" operations: **create**, **read**, **update** and **delete**.

The controller for this routes should extends the `ResourceController` contract which contains a method for each of the 
available resource operations:

    class ArticleController extends \Core\Controllers\Contracts\ResourceController
    {
        // ...
    }
