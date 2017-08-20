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

### Source hints

The `plural`and `singular` functions are based on Laravel's [Str class](https://github.com/illuminate/support/blob/5.3/Str.php Laravel's Str) 
and Laravel's [Pluralizer](https://github.com/illuminate/support/blob/5.3/Pluralizer.php), which again used the 
Doctrine's [Inflector](https://github.com/doctrine/inflector/tree/1.1.x Doctrine's), licensed under the
[MIT License](https://github.com/doctrine/inflector/blob/1.1.x/LICENSE).

`pascal_case`, `limit_string`, `slug` and `utf8_to_ascii` are copied from Laravel's [Str class](https://github.com/illuminate/support/blob/5.3/Str.php Laravel's Str).
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

`$charsArray` of the `utf8_to_ascii` method is adapted from [Stringy](https://github.com/danielstjules/Stringy/blob/master/src/Stringy.php) 
by Daniel St. Jules, licensed under the [MIT License](https://github.com/danielstjules/Stringy/blob/2.3.1/LICENSE.txt).


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
[workbench_path](#method-workbench-path)

</div>

### Strings

<div class="method-list" markdown="1">

[plural](#method-plural)
[singular](#method-singular)
[camel_case](#method-camel-case)
[lower_case](#method-lower-case)
[pascal_case](#method-pascal-case)
[random_string](#method-random_string)
[snake_case](#method-snake-case)
[title_case](#method-title-case)
[upper_case](#method-upper-case)
[limit_string](#method-limit-string)
[slug](#method-slug)
[utf8_to_ascii](#method-utf8-to-ascii)

</div>

### Miscellaneous

<div class="method-list" markdown="1">

[abort](#method-abort)
[asset](#method-asset)
[bcrypt](#method-bcrypt)
[benchmark](#method-benchmark)
[command](#method-command)
[config](#method-config)
[csrf_token](#method-csrf-token)
[dump](#method-dump)
[dd](#method-dd)
[e](#method-e)
[env](#method-env)
[error](#method-error)
[guess_file_extension](#method-guess-file-extension)
[http_status_text](#method-http-status-text)
[is_absolute_path](#method-absolute-path)
[is_console](#method-is-console)
[is_testing](#method-is-testing)
[is_windows](#method-is-windows)
[list_files](#method-list-files)
[list_classes](#method-list-classes)
[locale](#method-locale)
[mail-address](#method-mail-address)
[make_dir](#method-make-dir)
[message](#method-message)
[old](#method-old)
[redirect](#method-redirect)
[remove_dir](#method-remove-dir)
[t](#method-t)
[url](#method-url)
<!--
[format_datetime](#method-format-datetime)
[format_date](#method-format-date)
[format_time](#method-format-time)
-->

</div>

### Services

<div class="method-list" markdown="1">

[asset_manager](#method-asset-manager)
[auth](#method-auth)
[cache](#method-cache)
[collect](#method-collect)
[cookie](#method-cookie)
[database](#method-database)
[datetime](#method-datetime)
[di](#method-di)
[logger](#method-logger)
[mailer](#method-mailer)
[migrator](#method-migrator)
[mime_type](#method-mime-type)
[paginator](#method-paginator)
[plugin_manager](#method-plugin-manager)
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


<a name="method-workbench-path"></a>
#### `workbench_path()` {.method}

The `workbench_path` function returns the fully qualified path to the workbench directory. 
You may also use the `workbench_path` function to generate a fully qualified path to a given file relative to the workbench directory:

    $path = workbench_path();

    $file = workbench_path('npm-asset/jquery/dist/jquery.min.js');


<a name="strings"></a>
### Strings

<a name="method-plural"></a>
#### `plural` {.method}

Get the plural form of an english word.

    $s = plural('person'); // people


<a name="method-singular"></a>
#### `singular()` {.method}

Get the singular form of an english word.

    $s = singular('children'); // child


<a name="method-camel-case"></a>
#### `camel_case()` {.method}

Converts a word to camel case (camelCase).

This is useful to convert a word into the format for a variable or method name.

    $s = camel_case('Cogito ergo sum'); // cogitoErgoSum


<a name="method-lower-case"></a>
#### `lower_case()` {.method}

Convert the given word to lower case.

    $s = lower_case('Cogito ergo sum'); // cogito ergo sum


<a name="method-pascal-case"></a>
#### `pascal_case()` {.method}

Converts the given word to pascal case, also known as studly caps case (PascalCase).

This is useful to convert a word into the format for a class name.

    $s = pascal_case('Cogito ergo sum'); // CogitoErgoSum


<a name="method-random_string"></a>
#### `random_string()` {.method}

The `random_string` generates cryptographically secure pseudo-random alpha-numeric string.

    $token = random_string(40); // 6L1oKbruRg71YT4bjtsgdndxVQzXn8dUNHIrTQql


<a name="method-snake-case"></a>
#### `snake_case()` {.method}

Convert the given word to snake case (snake_case).

This is useful to converts a word into the format for a table or a global function name.

    $s = snake_case('CogitoErgoSum'); // cogito_ergo_sum


<a name="method-title-case"></a>
#### `title_case()` {.method}

Convert the given word to title case (Title Case).

    $s = title_case('Cogito ergo sum'); // Cogito Ergo Sum


<a name="method-upper-case"></a>
#### `upper_case()` {.method}

Convert the given word to upper case.

    $s = upper_case('Cogito ergo sum'); // COGITO ERGO SUM


<a name="method-limit-string"></a>
#### `limit_string()` {.method}

Limit the number of characters in a string.

    $s = limit_string('If you can dream it, you can do it.', 20); // If you can dream it,...


<a name="method-slug"></a>
#### `slug()` {.method}

Generate a URL friendly "slug" from a given string.

    $s = slug('If you can dream it, you can do it.'); // if-you-can-dream-it-you-can-do-it


<a name="method-utf8-to-ascii"></a>
#### `utf8_to_ascii()` {.method}

Transliterate a UTF-8 value to ASCII.

    $s = utf8_to_ascii('© 2017'); // (c) 2017


<a name="miscellaneous"></a>
### Miscellaneous

<a name="method-abort"></a>
#### `abort()` {.method .first-method}

The `abort` function throws a HTTP exception which will be rendered by the exception handler:

    abort(Response::HTTP_UNAUTHORIZED);

You may also provide the exception's response text:

    abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized.');


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
    
    
<a name="method-bcrypt"></a>
#### `bcrypt()` {.method}

The `bcrypt` function creates a password hash using the <b>CRYPT_BLOWFISH</b> algorithm.

    $hash = bcrypt('psss...');  
      
    
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


<a name="method-csrf-token"></a>
#### `csrf_token()` {.method}

The `csrf_token` function gets the session's [CSRF token value](https://en.wikipedia.org/wiki/Cross-site_request_forgery). 
It's useful for the a web form:
 
    <input type="hidden" name="_token" value="{{csrf_token()}}"/> 
    
> <i class="fa fa-info fa-2x" aria-hidden="true"></i>
> The CSRF token is stored in the session under the `'_csrf_token'´ key.

    
<a name="method-dump"></a>
#### `dump()` {.method}

The `dump` function dumps the given variables:

    dump($value);
    
If you set the second argument to true, dump() will return the information rather than print it:

    $dump = dump($value, true);
    
    
<a name="method-dd"></a>
#### `dd()` {.method}

The `dd` function dumps the given variables and ends execution of the script:

    dd($value);

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

    
<a name="method-error"></a>
#### `error()` {.method}

The `error` function retrieves an error message from the flash for the given key:

    $error = error('email');
            
`error()` is a shortcut for:

    $error = flash()->get('errors.' . $key)        
     
You can set the error message with the [withError](response#method-with-error) or [withErrors](response#method-with-errors)
method of the `Response` object.
        
<!--

<a name="method-format-datetime"></a>
#### `format_datetime()` {.method}

Returns the given datetime formatted by the apps settings.

    echo format_datetime('2017-03-18 15:30:00'); // '18.03.2017 15:30:00'
    
<a name="method-format-date"></a>
#### `format_date()` {.method}

Returns the given date formatted by the apps settings.

    echo format_datetime('2017-03-18 15:30:00'); // '18.03.2017'


<a name="method-format-time"></a>
#### `format_time()` {.method}

Returns the given time formatted by the apps settings.

    echo format_datetime('2017-03-18 15:30:00'); // '15:30'

-->
  
   
<a name="method-guess-file-extension"></a>
#### `guess_file_extension()` {.method}

The `guess_file_extension` function returns the file extension based on the mime type. If the mime type is unknown, 
returns false.

    $ext = guess_file_extension('image/gif'); // 'gif'
  
  
<a name="method-http-status-text"></a>
#### `http_status_text()` {.method}

The `http_status_text` function translates a HTTP Status code to plain text:

    echo http_status_text(Response::HTTP_BAD_REQUEST);
            
   
<a name="method-is-absolute-path"></a>
#### `is__absolute_path()` {.method}

The `is_absolute_path` function determines if the given path given is an absolute path:

    $isAbs = is_absolute_path('/tmp'));
    
    
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

    
<a name="method-is-windows"></a>
#### `is_windows()` {.method}

The `is_windows` function determines if the os is windows:

    $win = is_windows();

    
<a name="method-list-files"></a>
#### `list_files()` {.method}

The `list_files` function reads files recursive:

    list_files($result, $path);

    
<a name="method-list-classes"></a>
#### `list_classes()` {.method}

The `list_classes` function reads available PHP classes recursive from given path:

    list_classes($result, app_path('Commands'), 'App\Commands');

    
<a name="method-locale"></a>
#### `locale()` {.method}

The `locale` function gets and sets the current locale:

    locale('fr');
    
    $locale = locale();
        

<a name="method-mail-address"></a>
#### `mail_address()` {.method}

The `mail_address` function gets the email address without the name:

    $email = mail_address('Webmailer <mail@example.com>'); // "mail@example.com"


<a name="method-make-dir"></a>
#### `make_dir()` {.method}

The `make_dir` function creates a folder recursive:

    make_dir(storage_path('temp'), 0777);


<a name="method-message"></a>
#### `message()` {.method}

The `message` function retrieves an message from the flash:

    message()
            
`message()` is a shortcut for:

    flash()->get('message')
           
See also [withMessage](responses#method-with-message) method of `Response` object.
            
            
<a name="method-old"></a>
#### `old()` {.method}

The `old` function retrieves an old input item from the flash. It is useful in a web form:

    <input type="email" id="email" name="email" value="{{old('email')}}"/>
            
`old()` is a shortcut for:

    flash()->get('input' . $key)

See also [withInput](responses#method-with-input) method of `Response` object.
    
    
<a name="method-redirect"></a>
#### `redirect()` {.method}

The `redirect` function returns a redirect HTTP response to the given path. The path should be relative to 
[request()->baseUrl()](requests#method-base-url):
    
    $redirect = redirect('home');

If you wish you could set GET parameters as second argument:
    
    $redirect = redirect('home', ['name' => 'Peter']);

The default HTTP status is 302 for a temporarily link. You can create a permanently redirect link like this:

    $redirect = redirect('home', ['name' => 'Peter'], 301);   
  
                
<a name="method-remove-dir"></a>
#### `remove_dir()` {.method}

The `remove_dir` function deletes a folder (or file). The folder does not have to be empty.

    remove_dir(storage_path('temp'));

               
<a name="method-t"></a>
#### `t()` {.method}

The `t` function translates the given language line using your localization:

    echo t('validation.required');
        
        
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


<a name="method-auth"></a>
#### `auth()` {.method}

The `auth` function gets the [Auth](authentication) object:

    $auth = auth();
    
    
<a name="method-cache"></a>
#### `cache()` {.method}

The `cache` function retrieves the [Cache](cache) instance for the given store:

    $cache = cache($store);
    

<a name="method-collect"></a>
#### `collect()` {.method}

The `collect` function creates a [Collection](collections) instance:

    $collect = collect(['red', 'yellow', 'green']);
      
      
<a name="method-cookie"></a>
#### `cookie()` {.method}

The `cookie` function creates a [Cookie](cookie) instance:

    cookie()->set('foo', 'bar', 1440);
    
    $foo = cookie()->get('foo');
      

<a name="method-database"></a>
#### `database()` {.method}

The `database` function retrieves the [Database](database) instance for the given store:

    $db = database(); // default store
    
    $db = database('testdb'); // store defined in config/database.php  


<a name="method-datetime"></a>
#### `datetime()` {.method}

The `datetime` function creates a advanced [DateTime](datetime) instance:

    $now = datetime();
    
    $christmas = datetime('2017-12-24');
    

<a name="method-di"></a>
#### `di()` {.method}

The `di` function retrieves the [Dependency Injector](di) instance:

    $di = di();
    
    
<a name="method-logger"></a>
#### `logger()` {.method}

The `logger` function retrieves the [Logger](logging) instance:

    logger()->log('debug', $message);


<a name="method-mailer"></a>
#### `mailer()` {.method}

The `mailer` function retrieves the [Mailer](mailer) instance:

    mailer()->send($to, $cc, $bcc, $subject, $body, $attachments);


<a name="method-migrator"></a>
#### `migrator()` {.method}

The `migrator` function retrieves the [Migrator](migrations) instance for the given store:

    $migrator = migrator($store)

> Typically, you do not need access the Migrator programmatically. Instead, use the Pletfix console command 'migrate'.


<a name="method-mime_type"></a>
#### `mime_type()` {.method}

The `mime_type` function gets the MIME Type of the given file. Returns false, if the file does not exist or the mime
type is unknown.

    $mime = mime_type(storage_path('upload/image123.gif'));


<a name="method-paginator"></a>
#### `paginator()` {.method}

The `paginator` function creates a [Paginator](pagination) instance for generating pagination controls, typical used in 
an `index` action:

    public function index()
    {
        $builder   = User::builder();
        $paginator = paginator($builder->count());
        $users     = $builder->offset($paginator->offset())->limit($paginator->limit())->all();
        
        return view('admin.users.index', compact('paginator', 'users'));
    }
    
    
<a name="method-plugin-manager"></a>
#### `plugin_manager()` {.method}

The `plugin_manager` function creates a [PluginManager](plugins) instance for the given package:

    $pluginManager = plugin_manager($package)

> Typically, you do not need access the Plugin Manager programmatically. Instead, use the Pletfix console command 'plugin'.


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

If you read a specify value from the session, you may do it like this:
    
    $value = session('key', 'default');


<a name="method-stdio"></a>
#### `stdio()` {.method}

The `stdio` function retrieves the Stdio instance for the Pletfix [console](console):

    $stdio = return stdio();


<a name="method-view"></a>
#### `view()` {.method}

Create a response with the given [View](view).

    return view('welcome', ['name' => 'Frank']);

If no arguments are passed, the function returns a new View instance. So, the example below is the same like above:

    $output = view()->render('welcome', ['name' => 'Frank']);
    
    return $this->output($output);
