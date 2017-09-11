# Authentication

_Making sure you build secure applications_

[Since 0.6.3]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Create a Auth Instance](#instance)
- [Login and Logout](#login)
- [Determine the Role and Abilities](#check)
- [View](#view)
- [Middleware](#middleware)

<a name="introduction"></a>
## Introduction

Postfix provides a simple way to manage the user roles and to control the access to the application. 

For this purpose there is the `Auth` service out of the box, with which the user can be logged in and, of course, can 
also be logged out. In addition, there are a few middleware to control the user access. This middleware, in turn, uses 
the `Auth` service to find out which skills the user has. 

In addition, the template system offers the possibility to design the view in dependency of the logged on user. Again, 
the Auth object is accessed to determine the user's abilities.

<a name="configuration"></a>
## Configuration

The configuration is located at `config/auth.php`. In this file you may specify the user roles the access control list.

In addtional you can set the user model which stores the user accounts. The user model should be provides the following 
attributes: 
<pre>
- name               (string) The display name of the user.
- email              (string) The email address of the user.
- password           (string) Password hash created with the [`bcrypt()`](helpers#method-bcrypt) function.
- principal          (string) Reserved for an addtional unique identifier, could be used by third party plugins.   
- confirmation_token (string) Reserved for an double opt-in registration process, could be used by third party plugins.
- remember_token     (string) "Remember-Me" token, is used if the user ticks the "remember-me" flag. 
</pre>

The default user model is `App\Models\User`. If you have installed the [Pletfix Application Skeleton](https://github.com/pletfix/app), 
the model and the database table are already created.

> <i class="fa fa-lightbulb-o fa-2x" aria-hidden="true"></i>
> The [Authenticaton Plugin](https://github.com/pletfix/auth-plugin) contains a forms to manage the user 
> accounts stored in this table.

<a name="instance"></a>
## Create a Auth Instance
   
You may use the `auth()` function to access a `Auth` instance:

    $auth = auth();
    
> The `auth()` function is just a shortcut to get the `Auth` instance supported by [Dependency Injector](di): 
>    
>       $auth = DI::getInstance()->get('auth');
   
   
<a name="login"></a>
## Login and Logout

#### `login()` {.method}

You may login the user with the `login` method:        

    $auth->login($credentials);
    
The argument `$credentials` is an array to hold the email or name of the user and the password.

Pletfix does not provide the way to receive this user credentials out of the box, because there are too many possibilities.
Instead you may install a Plugin such like [Authenticaton Plugin](https://github.com/pletfix/auth-plugin) for basic 
web login, [Ldap Plugin](https://github.com/pletfix/ldap-plugin) for authentication through an Active Directory or 
[OAuth Plugin](https://github.com/pletfix/oauth-plugin) for authorizing through a Socialite provider as like Facebook or Dropbox.

![Login](https://raw.githubusercontent.com/pletfix/auth-plugin/master/docs/screenshot4.png)

The credentials could be an additional attribute names 'remember'. If this attribute true, the `Auth` service creates a
a long life (5 years) cookie on the browser. In this case the user will be re-login automaticaly after the PHP session 
expires (because has close the browser and opens it later for example).

#### `logout()` {.method}

Use the `logout` method to log the user out of the application:

    public function logout();

#### `setPrincipal()` {.method}

If you have check the credentials already (e.g. through an another authentication server), you can set the user 
principal like this: 

    public function setPrincipal($id, $name, $role);

The first argument `$id` is a unique identifier of the user. If you use a database model to store the user accounts as 
the default [Pletfix Application Skeleton](https://github.com/pletfix/app) does, the `$id` should be the user ID of the 
model. If you don't use a model, you could use any other unique user attribute or you could generate a unique id just 
in time like PHP's `uniqid()` function.

The second argument `$name` is the display name of the user. The last argument `$role` should be a role which is defined 
in the configuration file `config/auth.php`.


<a name="check"></a>
## Determine the Role and Abilities

#### `isLoggedIn()` {.method}
    
Determine if the current user is authenticated like this:

    $isLoggedIn = $auth->isLoggedIn();

#### `role()` {.method}

Get the role of the current user:

    $role = $auth->role();

#### `is()` {.method}

Determine if the current user is the given role, e.g. an admin:

    $isAdmin = $auth->is('admin');

#### `abilities()` {.method}

Get the abilities of the current user:
     
    $abilities = $auth->abilities();

#### `can()` {.method}

Determine if the user has the given ability, e.g. "manage-user":

    $canManageUser = $auth->can('manage-user');
     
     
<a name="view"></a>            
## View

### User Role Check

You can use the Blade directive `@is` to check the role within in the view:

    @is('admin')
        I'm the admin.
    @elseis('user')
        I'm a user.
    @elseis
        I'm a guest.
    @endis

Read the [Blade Quick Reference](blade#quick-role-check) to leran more about `@is` related directives. 

### User Ability Check

You can check the abilities of the user within the view like this:
        
    @can('manage-user')
        I can manage the user.
    @elsecan
        I cannot manage the user.
    @endcan
    
Read the [Blade Quick Reference](blade#quick-ability-check) to leran more about `@can` related directives. 
  
  
<a name="middleware"></a>
## Middleware

Pletfix provides the following middleware out of the box to control the user access. 

> <i class="fa fa-lightbulb-o fa-2x" aria-hidden="true"></i>
> Read [here](middleware) to learn more about how middleware works.

### Auth

You can use the `Auth` middleware to provide routes to authorized users only:

    $route->middleware('Auth', function(Route $route) {
        // members only...
    });

### Role

If you have routes for a specific user role, use the `Role` middleware: 

    $route->middleware('Role:admin', function (Route $route) {
    });

### Ability

And if the route is only for users with a certain ability, use the `Ability` middleware: 

    $route->middleware('Ability:manage-user', function(Route $route) {
    });  