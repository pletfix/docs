# Hello World - My first Application 

[Since 0.5.0]

- [First Steps](#first-steps)
- [Use a View](#view)
- [Add a Table](#table)
- [Add a Model](#model)

<a name="first-steps"></a>
## First Steps

Jede Einführung in der Software-Entwicklung beginnt mit der ultimativen Hello World Anwendung, oder nicht?

Ok, so geht es mit Pletfix:

1. Install a fresh [Pletfix Application](https://github.com/pletfix/app)

2. Open `config/boot/routes.php` and add a new route:

    ~~~php
    $route->get('hello', function() {
       return 'Hello World';      
    });
    ~~~

3. Open your browser and enter the URL to your new route:
    
    ~~~
    http://localhost/my-first-app/public/hello
    ~~~

    Vola! You will see: "Hello". What a surprise! 
    
<a name="view"></a>    
## Use a View

Pletfix is a MVC (Model-View-Controller) framework, so we will use a View to output the greetings:
 
4. Create a new File `hello.blade.php` in the subfolder `resources/views` and add the following content:

    ~~~html
    @extends('app')
    
    @section('content')
    
        <h1>Hello World</h1>
    
    @endsection
    ~~~
 
5. Modify the route in `config/boot/routes.php` so that the view is called and the output string is not returned directly:
 
    ~~~php
    $route->get('hello', function() {
        return view('hello');
    });
    ~~~
        
6. Reload the browser and be happy:
    
    ~~~
    http://localhost/my-first-app/public/hello
    ~~~
    
<a name="controller"></a>    
## Use a Controller

Our application is really simple - so it is ok adding the logic into the route file directly.
But as soon as something more logic is added, it quickly becomes confusing.
To prevent this let's add a controller:

7. Create a new Controller `HelloController.php` in the subfolder `app/Controllers`:

    ~~~
    <?php
    
    namespace App\Controllers;
    
    class HelloController extends Controller
    {
        public function index()
        {
            return view('hello');
        }
    }
    ~~~
    
8. We modify the route in ones more so our Controller is called:
 
    ~~~php
    $route->get('hello', 'HelloController@index');
    ~~~
        
9. Reload the browser - the output is the same as the last time:
    
    ~~~
    http://localhost/my-first-app/public/hello
    ~~~
    
## Create a Table

TODO

## Add a Model 
    
Planned release: 0.6.0
TODO    
    