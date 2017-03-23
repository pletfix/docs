# Views

_Creating output_

[Since 0.5.0]

- [Introduction](#introduction)
- [Creating Views](#blade)
- [Rendering Views](#rendering)

<a name="introduction"></a>
## Introduction

Views contain the HTML served by your application and separate your business logic from your presentation logic. 

<a name="blade"></a>
## Creating Views

Pletfix supported a kind of [Laravel's Blade Engine](https://laravel.com/docs/5.3/blade).
 
A simple view might look something like this:

    <html>
        <body>
            <h1>Hello, {{ $name }}</h1>
        </body>
    </html>

See Chapter [Blade Templates](blade) for the detailed description of the template syntax.

<a name="rendering"></a>
## Rendering Views

Suppose a view is stored at `resources/views/greeting.blade.php`, we may return it as raw PHP code like so:

    $route->get('', function () {
        /** @var \Core\Services\Contracts\View $view */
        $view = DI::getInstance()->get('view');
        return $view->render('greeting', ['name' => 'James']);
    });

You can also use the global `view()` function to render the view, it's far shorter:

    $route->get('', function () {
        return view('greeting', ['name' => 'James']);
    });

As you can see, the first argument passed to the `view` helper (or `render` function) corresponds to the name of the view file in the `resources/views` directory. 
The second argument is an array of data that should be made available to the view. 
In this case, we are passing the `name` variable, which is displayed in the view.

### Sub-Directories

Of course, views may also be nested within sub-directories of the `resources/views` directory. 
"Dot" notation may be used to reference nested views. 
For example, if your view is stored at `resources/views/admin/profile.blade.php`, you may reference it like so:

    return view('admin.profile', $data);

<a name="response"></a>
### Response's Status and Headers

If you need control over the response's status and headers, you should use the `response` helper:

    return response()->view($name, $variables = [], 200, ['Content-Type' => 'text/plain']);   

<a name="exists"></a>
### Determining if a View exists

You may use the `view()` function without parameters to get an instance of the `View` object. 
This is useful e.g. to determining if a view exists:

    if (view()->exists('emails.customer')) {
        //
    }
