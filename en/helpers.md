# Helpers & Services

[Since 0.5.0]

TODO: Anpassen

- [Introduction](#introduction)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

Out of the box, Pletfix provides a collection of functions for accessing the services that are bound in the 
[Dependency Injection Container](di). The functions are defined in `vendor/pletfix/core/functions/services.php`.

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
[config](#method-config)
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

### Services

<div class="method-list" markdown="1">

[asset_manager](#method-asset-manager)
[cache](#method-cache)
[collect](#method-collect)
[database](#method-database)
[datetime](#method-datetime)
[di](#method-di)
[logger](#method-logger)
[migrator](#method-migrator)
[plugin_manager](#method-plugin-manager)
[query_builder](#method-query-builder)
[request](#method-request)
[response](#method-response)
[session](#method-session)
[stdio](#method-stdio)
[view](#method-view)

</div>

<a name="method-listing"></a>
## Method Listing

<a name="paths"></a>
### Paths

<a name="method-app-path"></a>
#### `app_path()` {.method .first-method}

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
### Miscellaneous

<a name="method-abort"></a>
#### `abort()` {.method .first-method}

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


<a name="method-config"></a>
#### `config()` {.method}

The `config` function gets the value of a configuration variable. 

The configuration values may be accessed using "dot" syntax, which includes the name of the file and the option you 
wish to access: 

    $timezone = config('app.timezone');

A default value may be specified and is returned if the configuration option does not exist:

    $debugMode = config('app.debug', 'false'); 

    
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

    
<a name="services"></a>
### Services

<a name="method-asset-manager"></a>
#### `asset_manager()` {.method .first-method}

The `asset_manager` function gets the [AssetManager](assets) instance:

    $assetManager = asset_manager()
    
    
> Typically, you do not need access the Asset Manager programmatically. Instead, use the Pletfix console command 'asset'.     


<a name="method-cache"></a>
#### `cache()` {.method}

The `cache` function retrieves the [Cache](cache) instance for the given store:

    $cache = cache($store);
    

<a name="method-collect"></a>
#### `collect()` {.method}

The `collect` function creates a [Collection](collections) instance:

    $collect = collect(['red', 'yellow', 'green']);
      

<a name="method-database"></a>
#### `database()` {.method}

The `database` function retrieves the [Database](database) instance for the given store:

    $db = database(); // default store
    
    $db = database('testdb'); // store defined in config/database.php  


<a name="method-datetime"></a>
#### `datetime()` {.method}

The `datetime` function creates a [DateTime](datetime) instance:

    $now = datetime();


<a name="method-di"></a>
#### `di()` {.method}

The `di` function retrieves the [Dependency Injector](di) instance:

    $di = di();
    

<a name="method-logger"></a>
#### `logger()` {.method}

The `logger` function retrieves the [Logger](logging) instance:

    logger()->log('debug', $message);


<a name="method-migrator"></a>
#### `migrator()` {.method}

The `migrator` function retrieves the [Migrator](migrations) instance for the given store:

    $migrator = migrator($store)

> Typically, you do not need access the Migrator programmatically. Instead, use the Pletfix console command 'migrate'.


<a name="method-plugin-manager"></a>
#### `plugin_manager()` {.method}

The `plugin_manager` function creates a [PluginManager](plugins) instance for the given package:

    $pluginManager = plugin_manager($package)

> Typically, you do not need access the Plugin Manager programmatically. Instead, use the Pletfix console command 'plugin'.


<a name="method-query-builder"></a>
#### `query_builder()` {.method}

The `query_builder` function retrieves the [QueryBuilder](queries) instance for the given store:

    $builder = query_builder($store);
    

<a name="method-request"></a>
#### `request()` {.method}

The `request` function retrieves the [Request](requests) instance:

    $request = request()


<a name="method-response"></a>
#### `response()` {.method}

The `response` function retrieves the [Response](responses) instance:

    return response()->output('Hello World', 200, $headers);


<a name="method-session"></a>
#### `session()` {.method}

The `session` function retrieves the [Session](sessions) instance:

    $session = session();


<a name="method-stdio"></a>
#### `stdio()` {.method}

The `stdio` function retrieves the Stdio instance for the Pletfix [console](console):

    $stdio = return stdio();


<a name="method-view"></a>
#### `view()` {.method}

The `view` function creates a [View](views) instance for the given template:

    return view('welcome', ['name' => 'Frank']);
