# Helpers

[Since 0.5.0]

TODO: Anpassen

- [Introduction](#introduction)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

Pletfix includes a variety of global functions to access a service in a shortcut way in `vendor/pletfix/core/functions/services.php`.

Additional helper function are defined in `vendor/pletfix/core/functions/helpers.php`.

You are free to use them in your own applications if you find them convenient.

<a name="available-methods"></a>
## Available Methods

### Paths

<div class="method-list" markdown="1">

[app_path](#method-app-path)
[base_path](#method-base-path)
[config_path](#method-config-path)
[manifest_path](#method-manifest-path)
[public_path](#method-public-path)
[resource_path](#method-resource-path)
[storage_path](#method-storage-path)
[vendor_path](#method-vendor-path)

</div>

### Miscellaneous

<div class="method-list" markdown="1">

[abort](#method-abort)
[asset](#method-asset)
[benchmark](#method-benchmark)
[command](#method-command)
[dump](#method-dump)
[dd](#method-dd)
[e](#method-e)
[env](#method-env)
[is_console](#method-is-console)
[is_testing](#method-is-testing)
[is_win](#method-is-win)
[lang](#method-lang)
[list_files](#method-list-files)
[list_classes](#method-list-classes)
[remove_folder](#method-remove-folder)
[url](#method-url)

</div>

<!--
[auth](#method-auth)
[back](#method-back)
[bcrypt](#method-bcrypt)
[cache](#method-cache)
[collect](#method-collect)
[config](#method-config)
[csrf_field](#method-csrf-field)
[csrf_token](#method-csrf-token)
[dispatch](#method-dispatch)
[event](#method-event)
[factory](#method-factory)
[info](#method-info)
[logger](#method-logger)
[method_field](#method-method-field)
[old](#method-old)
[redirect](#method-redirect)
[request](#method-request)
[response](#method-response)
[retry](#method-retry)
[session](#method-session)
[value](#method-value)
[view](#method-view)
[camel_case](#method-camel-case)
[class_basename](#method-class-basename)
[ends_with](#method-ends-with)
[snake_case](#method-snake-case)
[str_limit](#method-str-limit)
[starts_with](#method-starts-with)
[str_contains](#method-str-contains)
[str_finish](#method-str-finish)
[str_is](#method-str-is)
[str_plural](#method-str-plural)
[str_random](#method-str-random)
[str_singular](#method-str-singular)
[str_slug](#method-str-slug)
[studly_case](#method-studly-case)
[title_case](#method-title-case)
[trans](#method-trans)
[trans_choice](#method-trans-choice)
-->

<a name="method-listing"></a>
## Method Listing

<a name="paths"></a>
### Paths  {.method}

<a name="method-app-path"></a>
#### `app_path()` {.method}

The `app_path` function returns the fully qualified path to the `app` directory. 
You may also use the `app_path` function to generate a fully qualified path to a file relative to the application directory:

    $path = app_path();

    $file = app_path('Http/Controllers/Controller.php');


<a name="method-base-path"></a>
#### `base_path()` {.method}

The `base_path` function returns the fully qualified path to the project root. 
You may also use the `base_path` function to generate a fully qualified path to a given file relative to the project root directory:

    $path = base_path();

    $path = base_path('vendor/bin');


<a name="method-config-path"></a>
#### `config_path()` {.method}

The `config_path` function returns the fully qualified path to the application configuration directory:

    $path = config_path();


<a name="method-manifest-path"></a>
#### `manifest_path()` {.method}

The `manifest_path` function returns the fully qualified path to the hidden manifest folder:

    $path = manifest_path();


<a name="method-public-path"></a>
#### `public_path()` {.method}

The `public_path` function returns the fully qualified path to the `public` directory:
You may also use the `public_path` function to generate a fully qualified path to a given file relative to the public directory:

    $path = public_path();
    
    $file = public_path('images/logo.png');


<a name="method-resource-path"></a>
#### `resource_path()` {.method}

The `resource_path` function returns the fully qualified path to the `resources` directory. 
You may also use the `resource_path` function to generate a fully qualified path to a given file relative to the resources directory:

    $path = resource_path();

    $file = resource_path('assets/sass/app.scss');


<a name="method-storage-path"></a>
#### `storage_path()` {.method}

The `storage_path` function returns the fully qualified path to the writable storage directory. 
You may also use the `storage_path` function to generate a fully qualified path to a given file relative to the storage directory:

    $path = storage_path();

    $file = storage_path('app/file.txt');


<a name="method-vendor-path"></a>
#### `vendor_path()` {.method}

The `vendor_path` function returns the fully qualified path to the vendor directory. 
You may also use the `vendor_path` function to generate a fully qualified path to a given file relative to the vendor directory:

    $path = vendor_path();

    $file = vendor_path('npm-asset/jquery/dist/jquery.min.js');


<a name="miscellaneous"></a>
### Miscellaneous {.method}

<a name="method-abort"></a>
#### `abort()` {.method}

The `abort` function throws a HTTP exception which will be rendered by the exception handler:

    abort(HTTP_STATUS_UNAUTHORIZED);

You may also provide the exception's response text:

    abort(HTTP_STATUS_UNAUTHORIZED, 'Unauthorized.');


<a name="method-asset"></a>
#### `asset()` {.method}

The `asset` function generates the URL to an application asset.

    <script src="{{ asset('js/app.js') }}"></script>

    
<a name="method-benchmark"></a>
#### `benchmark()` {.method}

The `benchmark` function prints the elapsed time in milliseconds and the memory usage in bytes that the callback function needs:

    benchmark(function($loop) {
        // your test code
    });

You can specify the number of calls in the second argument. 
Furthermore, if you set the third argument to true, benchmark() will return the information rather than print it:
    
    $result = benchmark(function($loop) {
        // your test code
    }, 100, true);    
    
    
<a name="method-command"></a>
#### `command()` {.method}

The `command` function runs a console command by name.:

    command('migrate', ['-r']);

    
<a name="method-dump"></a>
#### `dump()` {.method}

The `dump` function dumps the given variables:

    dump($value);
    
If you set the third argument to true, dump() will return the information rather than print it:

    $dump = dump($value, true);
    
    
<a name="method-dd"></a>
#### `dd()` {.method}

The `dd` function dumps the given variables and ends execution of the script:

    dd($value);

    dd($value1, $value2, $value3, ...);

If you do not want to halt the execution of your script, use the [dump](#method-dump) function instead.

    
#### `e()` {.method}

The `e` function runs `htmlspecialchars` over the given string:

    echo e('<html>foo</html>');

    // &lt;html&gt;foo&lt;/html&gt;
    
This function is called too if you echo a variable in a blade template with the normal echo tags:
 
    {{ $var }}     

    
<a name="method-env"></a>
#### `env()` {.method}

The `env` function gets the value of an environment variable or returns a default value:

    $env = env('APP_ENV');

    // Return a default value if the variable doesn't exist...
    $env = env('APP_ENV', 'production');

> IMPORTANT:
> If the config was cached the environment file ".env" is not read. Therefore you should never use this function directly, instead only in the configuration files.
    
    
<a name="method-is-console"></a>
#### `is_console()` {.method}

The `is_console` function determines if we are running in the console:

    if (is_console()) {
        echo 'This is a console!';
    }

    
<a name="method-is-testing"></a>
#### `is_testing()` {.method}

The `is_testing` function determines if we are running unit tests.

    if (is_testing()) {
        echo 'The environment variable APP_ENV is set to "testing".';
    }

    
<a name="method-is-win"></a>
#### `is_win()` {.method}

The `is_win` function determines if the os is windows:

    $win = is_win();

    
<a name="method-lang"></a>
#### `lang()` {.method}

The `lang` function translates the given language line using your localization:

    echo lang('validation.required');

    
<a name="method-list-files"></a>
#### `list_files()` {.method}

The `list_files` function reads files recursive:

    list_files($result, $path);

    
<a name="method-list-classes"></a>
#### `list_classes()` {.method}

The `list_classes` function reads available PHP classes recursive from given path:

    list_classes($result, app_path('Commands'), 'App\Commands');

    
<a name="method-remove-folder"></a>
#### `remove_folder()` {.method}

The `remove_folder` function deletes a folder (or file):

    remove_folder(storage_path('temp'));

    
<a name="method-url"></a>
#### `url()` {.method}

The `url` function generates a absolute URL to the given path.

    $url = url('public/images/logo.png');

    






<!-- 
<a name="method-auth"></a>
#### `auth()` {.method}

The `auth` function returns an authenticator instance. You may use it instead of the `Auth` facade for convenience:

    $user = auth()->user();

<a name="method-back"></a>
#### `back()` {.method}

The `back()` function generates a redirect response to the user's previous location:

    return back();

<a name="method-bcrypt"></a>
#### `bcrypt()` {.method}

The `bcrypt` function hashes the given value using Bcrypt. You may use it as an alternative to the `Hash` facade:

    $password = bcrypt('my-secret-password');

<a name="method-cache"></a>
#### `cache()` {.method}

The `cache` function may be used to get values from the cache. If the given key does not exist in the cache, an optional default value will be returned:

    $value = cache('key');

    $value = cache('key', 'default');

You may add items to the cache by passing an array of key / value pairs to the function. You should also pass the number of minutes or duration the cached value should be considered valid:

    cache(['key' => 'value'], 5);

    cache(['key' => 'value'], Carbon::now()->addSeconds(10));

<a name="method-collect"></a>
#### `collect()` {.method}

The `collect` function creates a [collection](/docs/{{version}}/collections) instance from the given array:

    $collection = collect(['taylor', 'abigail']);

<a name="method-config"></a>
#### `config()` {.method}

The `config` function gets the value of a configuration variable. The configuration values may be accessed using "dot" syntax, which includes the name of the file and the option you wish to access. A default value may be specified and is returned if the configuration option does not exist:

    $value = config('app.timezone');

    $value = config('app.timezone', $default);

The `config` helper may also be used to set configuration variables at runtime by passing an array of key / value pairs:

    config(['app.debug' => true]);

<a name="method-csrf-field"></a>
#### `csrf_field()` {.method}

The `csrf_field` function generates an HTML `hidden` input field containing the value of the CSRF token. For example, using [Blade syntax](/docs/{{version}}/blade):

    {{ csrf_field() }}

<a name="method-csrf-token"></a>
#### `csrf_token()` {.method}

The `csrf_token` function retrieves the value of the current CSRF token:

    $token = csrf_token();

<a name="method-dispatch"></a>
#### `dispatch()` {.method}

The `dispatch` function pushes a new job onto the queue:

    dispatch(new App\Jobs\SendEmails);

<a name="method-event"></a>
#### `event()` {.method}

The `event` function dispatches the given [event](/docs/{{version}}/events) to its listeners:

    event(new UserRegistered($user));

<a name="method-factory"></a>
#### `factory()` {.method}

The `factory` function creates a model factory builder for a given class, name, and amount. It can be used while [testing](/docs/{{version}}/database-testing#writing-factories) or [seeding](/docs/{{version}}/seeding#using-model-factories):

    $user = factory(App\User::class)->make();

<a name="method-info"></a>
#### `info()` {.method}

The `info` function will write information to the log:

    info('Some helpful information!');

An array of contextual data may also be passed to the function:

    info('User login attempt failed.', ['id' => $user->id]);

<a name="method-logger"></a>
#### `logger()` {.method}

The `logger` function can be used to write a `debug` level message to the log:

    logger('Debug message');

An array of contextual data may also be passed to the function:

    logger('User has logged in.', ['id' => $user->id]);

A [logger](/docs/{{version}}/errors#logging) instance will be returned if no value is passed to the function:

    logger()->error('You are not allowed here.');

<a name="method-method-field"></a>
#### `method_field()` {.method}

The `method_field` function generates an HTML `hidden` input field containing the spoofed value of the form's HTTP verb. For example, using [Blade syntax](/docs/{{version}}/blade):

    <form method="POST">
        {{ method_field('DELETE') }}
    </form>

<a name="method-old"></a>
#### `old()` {.method}

The `old` function [retrieves](/docs/{{version}}/requests#retrieving-input) an old input value flashed into the session:

    $value = old('value');

    $value = old('value', 'default');

<a name="method-redirect"></a>
#### `redirect()` {.method}

The `redirect` function returns a redirect HTTP response, or returns the redirector instance if called with no arguments:

    return redirect('/home');

    return redirect()->route('route.name');

<a name="method-request"></a>
#### `request()` {.method}

The `request` function returns the current [request](/docs/{{version}}/requests) instance or obtains an input item:

    $request = request();

    $value = request('key', $default = null)

<a name="method-response"></a>
#### `response()` {.method}

The `response` function creates a [response](/docs/{{version}}/responses) instance or obtains an instance of the response factory:

    return response('Hello World', 200, $headers);

    return response()->json(['foo' => 'bar'], 200, $headers);

<a name="method-retry"></a>
#### `retry()` {.method}

The `retry` function attempts to execute the given callback until the given maximum attempt threshold is met. If the callback does not throw an exception, it's return value will be returned. If the callback throws an exception, it will automatically be retried. If the maximum attempt count is exceeded, the exception will be thrown:

    return retry(5, function () {
        // Attempt 5 times while resting 100ms in between attempts...
    }, 100);

<a name="method-session"></a>
#### `session()` {.method}

The `session` function may be used to get or set session values:

    $value = session('key');

You may set values by passing an array of key / value pairs to the function:

    session(['chairs' => 7, 'instruments' => 3]);

The session store will be returned if no value is passed to the function:

    $value = session()->get('key');

    session()->put('key', $value);

<a name="method-value"></a>
#### `value()` {.method}

The `value` function's behavior will simply return the value it is given. However, if you pass a `Closure` to the function, the `Closure` will be executed then its result will be returned:

    $value = value(function () {
        return 'bar';
    });

<a name="method-view"></a>
#### `view()` {.method}

The `view` function retrieves a [view](/docs/{{version}}/views) instance:

    return view('auth.login');

-->

<!--    
<a name="strings"></a>
### Strings {.method}

<a name="method-camel-case"></a>
#### `camel_case()` {.method}

The `camel_case` function converts the given string to `camelCase`:

    $camel = camel_case('foo_bar');

    // fooBar

<a name="method-class-basename"></a>
#### `class_basename()` {.method}

The `class_basename` returns the class name of the given class with the class' namespace removed:

    $class = class_basename('Foo\Bar\Baz');

    // Baz

<a name="method-ends-with"></a>
#### `ends_with()` {.method}

The `ends_with` function determines if the given string ends with the given value:

    $value = ends_with('This is my name', 'name');

    // true

<a name="method-snake-case"></a>
#### `snake_case()` {.method}

The `snake_case` function converts the given string to `snake_case`:

    $snake = snake_case('fooBar');

    // foo_bar

<a name="method-str-limit"></a>
#### `str_limit()` {.method}

The `str_limit` function limits the number of characters in a string. The function accepts a string as its first argument and the maximum number of resulting characters as its second argument:

    $value = str_limit('The PHP framework for web artisans.', 7);

    // The PHP...

<a name="method-starts-with"></a>
#### `starts_with()` {.method}

The `starts_with` function determines if the given string begins with the given value:

    $value = starts_with('This is my name', 'This');

    // true

<a name="method-str-contains"></a>
#### `str_contains()` {.method}

The `str_contains` function determines if the given string contains the given value:

    $value = str_contains('This is my name', 'my');

    // true

You may also pass an array of values to determine if the given string contains any of the values:

    $value = str_contains('This is my name', ['my', 'foo']);

    // true

<a name="method-str-finish"></a>
#### `str_finish()` {.method}

The `str_finish` function adds a single instance of the given value to a string:

    $string = str_finish('this/string', '/');

    // this/string/

<a name="method-str-is"></a>
#### `str_is()` {.method}

The `str_is` function determines if a given string matches a given pattern. Asterisks may be used to indicate wildcards:

    $value = str_is('foo*', 'foobar');

    // true

    $value = str_is('baz*', 'foobar');

    // false

<a name="method-str-plural"></a>
#### `str_plural()` {.method}

The `str_plural` function converts a string to its plural form. This function currently only supports the English language:

    $plural = str_plural('car');

    // cars

    $plural = str_plural('child');

    // children

You may provide an integer as a second argument to the function to retrieve the singular or plural form of the string:

    $plural = str_plural('child', 2);

    // children

    $plural = str_plural('child', 1);

    // child

<a name="method-str-random"></a>
#### `str_random()` {.method}

The `str_random` function generates a random string of the specified length. This function uses PHP's `random_bytes` function:

    $string = str_random(40);

<a name="method-str-singular"></a>
#### `str_singular()` {.method}

The `str_singular` function converts a string to its singular form. This function currently only supports the English language:

    $singular = str_singular('cars');

    // car

<a name="method-str-slug"></a>
#### `str_slug()` {.method}

The `str_slug` function generates a URL friendly "slug" from the given string:

    $title = str_slug('Pletfix Framework', '-');

    // pletfix-framework

<a name="method-studly-case"></a>
#### `studly_case()` {.method}

The `studly_case` function converts the given string to `StudlyCase`:

    $value = studly_case('foo_bar');

    // FooBar

<a name="method-title-case"></a>
#### `title_case()` {.method}

The `title_case` function converts the given string to `Title Case`:

    $title = title_case('a nice title uses the correct case');

    // A Nice Title Uses The Correct Case


<a name="method-trans-choice"></a>
#### `trans_choice()` {.method}

The `trans_choice` function translates the given language line with inflection:

    $value = trans_choice('foo.bar', $count);

-->