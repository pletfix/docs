# Plugins

_Extending the core_

[Since 0.5.0]

- [Introduction](#introduction)
- [Installing Plugins](#installing)
- [Registration Procedure](#registration-procedure)
- [Writing Plugins](#writing)
- [Deploying Plugins](#deploying)
    

<a name="introduction"></a>
## Introduction

Postfix offers a powerful plugin system, which allows you to expand your application quickly by other features that 
the community has developed. Of course, you can also develop plugins themselves and provide the community.

You will see that this is not very complicated.


<a name="installing"></a>
## Installing Plugins

<div class="method-list" markdown="1">

[List Plugins](#list-plugins)
[Downloading](#downloading)
[Registering](#registering)
[Updating](#updating)
[Removing](#removing)

</div>

<a name="list-plugins"></a>
### List Plugins

The help screen of the `plugin` command lists all enabled plugins. 

    php console plugin --help

<a name="downloading"></a>
### Downloading

Like the Pletfix Application, a Pletfix plugin is also a [Composer](https://getcomposer.org/) package. So it can be 
installed the same way. 

For example, let's install the actual useless Pletfix `hello` plugin as below:
    
1. We have not deployed our `hello` plugin on [Packagist](https://packagist.org/), the Composers default package archive.
   Therefore Composer cannot find the plugin if we don't say where it is. To do this, add this into your `composer.json`: 

       "repositories": [
           {
               "type": "git",
               "url": "git@github.com:pletfix/hello.git"
           }
       ],

   > <i class="fa fa-info fa-2x" aria-hidden="true"></i>
   > You can step over this point if you find the plugin on [Pletfix Plugin List](../../../plugins) or on [Packagist](https://packagist.org/).

2. Fetch the package by running the following terminal command:

       composer require pletfix/hello

<a name="registering"></a>
### Registering

After downloading, the plugin has to be registered. 

For example, enter this command in your terminal to register our `hello` plugin:

    php console plugin pletfix/hello 
 
> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> If the plugin provides a migration file, you have to execute the `migrate` command after the registration procedure,
> it won't run automatically!
>
>     php console migrate
                         
<a name="updating"></a>        
### Updating

If the plugin is already installed, you cannot install it once more. But you can use the `--update` option to update 
the manifest files, for our `hello` plugin like so:

    php console plugin pletfix/hello --update        
      
<a name="removing"></a>            
### Removing

Use the `--remove` option to unregister the plugin. Again the example with our `hello` plugin:

    php console plugin pletfix/hello --remove 
    
> The plugin package remains in the vendor directory. So you can register the plugin at any time again.         
            
            
<a name="registration-procedure"></a>
## Registration Procedure
	
When you register a plugin, the following things are happened:

<div class="method-list" markdown="1">

[1. Configuration](#configuration)
[2. Public Files](#public-files)
[3. Assets](#assets)
[4. Commands](#commands)
[5. Migrations](#migrations)
[6. Language Files](#language-files)
[7. Views](#views)
[8. Controllers](#controllers)
[9. Middleware](#middleware)
[10. Drivers](#drivers)
[11. Routes](#routes)
[12. Services](#services)
[13. Bootstraps](#bootstraps)
[14. Enable Plugin](#enable-plugin)

</div>

> <i class="fa fa-info fa-2x" aria-hidden="true"></i>
> **Definition of a term:** What exactly is the name of the plugin?
>
> The name of the plug-in is the name of the package without a vendor, and if present, without "pletfix-" as prefix 
> and "-plugin" as suffix.

<a name="configuration"></a>
### 1. Configuration

If available and if not already done, the configuration file of the plugin is copied to the `config` directory under 
the name of the plugin, e.g. `config/hello.php` for our `Hello` plugin.

<pre class="tree">
|-myapp/
   |-config/
      |-hello.php
</pre>

The configuration file will be not updated if it already exists. So you may customize the configuration as you wish.
   
Of course, you can read the configuration like all other configurations:
   
    $geeting = config('hello.gretting');   
   
<a name="public-files"></a>
### 2. Public Files 

If available, public files of the plugin will be copied into the application's public folder. For example, our `hello` 
plugin has one image file:

<pre class="tree">
|-myapp/
   |-public/
      |-images/
         |-hello/
            |-key.gif
</pre>

<a name="assets"></a>
### 3. Assets 

If available, the asset build file of the plugin will be added to the `.manifest/plugins/assets.php` manifest. After 
this the `AssetManager` publishes the assets of the plugin. For example, our `hello` plugin provides a `hello.js`  
script which will be published to `public/js/hello.js`.

    <?php return array (
      'hello' => 
      array (
        'js/hello.js' => 
        array (
          0 => 'vendor/pletfix/hello/assets/js/hello.js',
        ),
      ),
    );

You may repeat [publishing the assets](assets#publishing) manually if you enter this command in a terminal:   

   php console asset --plugin=hello 

<a name="commands"></a>
### 4. Commands 

If available, the commands embedded in the plugin will be added to the `.manifest/plugins/commands.php` manifest.   
The command factory reads this manifest if you enter `php console` to list all files.

    <?php return array (
      'examples:hello' => 
      array (
        'class' => 'Pletfix\\Hello\\Commands\\HelloCommand',
        'name' => 'hello:greeting',
        'description' => 'Say Hello!',
      ),
    );
    
You can execute the commands provided by plugins like all other commands:    
    
    php console hello:greeting
        
<a name="migrations"></a>
### 5. Migrations 

If available, the migration files embedded in the plugin will be added to the `.manifest/plugins/migrations.php` manifest.   

    <?php return array (
      '20170204121100_CreateHelloTable' => 'vendor/pletfix/hello/migrations/20170204121100_CreateHelloTable.php',
    );

Pletfix loads this manifest if you [run the migration](migrations#running).

<a name="language-files"></a>
### 6. Language Files 

If available, the language files of the plugin will be added to the `.manifest/plugins/lang` manifest.

    <?php return array (
      'de' => 
      array (
        'hello' => 'vendor/pletfix/hello/lang/de.php',
      ),
      'en' => 
      array (
        'hello' => 'vendor/pletfix/hello/lang/en.php',
      ),
    );

Pletfix loads this manifest for translating, so you may retrieve the translation entries from the plugin as follows,
where the top key is the plugin name:

    echo t('hello.greeting');
    
<a name="views"></a>
### 7. Views

If available, the path of the plugin's views will be added to the `.manifest/plugins/views.php` manifest. Pletfix needs 
this manifest to find the template for rendering.

    <?php return array (
      'admin.hello' => 'vendor/pletfix/hello/views/welcome.blade.php',
    );

For example, the `hello` plugin provides a view `welcome.blade.php`, so you may referred it as follows,
where the top key is the plugin name:

    return view('hello.welcome');

You can, of course, customize the views. To do this, create a subfolder named as the plugin under `resources/views`. 
Copy all files, that are stored under the plugin's view folder, into this subfolder. For example, the `welcome` view of 
our  `hello` plugin have to stored like this:

<pre class="tree">
|-myapp/
   |-resources/
      |-views/
         |-hello/
            |-welcome.blade.php
</pre>

<a name="controllers"></a>
### 8. Controllers

If available, the controllers embedded by the plugin will be added to the `.manifest/plugins/controllers.php` manifest.

    <?php return array (
      'HelloController' => 
      array (
        0 => 'Pletfix\\Hello\\Controllers\\HelloController',
      ),
    );

Pletfix uses this manifest to find the controller, so you can reference the controllers in the routes without 
the full namespace unless the name is unique by the enabled plugins:

    $route->get('hello', 'HelloController@index');
    
If the name of the controller without "My-Vender/My-Plugin/Controllers/" portion is not unique, you must use the fully 
qualified name:

    $route->get('hello', '\Pletfix\Hello\Controllers\HelloController@index');

<a name="middleware"></a>
### 9. Middleware

If available, the middleware embedded by the plugin will be added to the `.manifest/plugins/middleware.php` manifest.

    <?php return array (
      'Hello' => 
      array (
        0 => 'Pletfix\\Hello\\Middleware\\Hello',
      ),
    );

As with the controllers, the middleware can also be referenced:

    $route->middlware('Hello');
    
The same applies here, if the name of the middleware without "My-Vender/My-Plugin/Middlware/" portion is not unique, 
you must use the fully qualified name:

    $route->middlware('\Pletfix\Hello\Middleware\Hello');

<a name="drivers"></a>
### 10. Drivers

All classes that stored in a subdirectory under the plugin's `./src/Drivers` directory will be added to the 
`.manifest/plugins/drivers.php` manifest, grouped to the top subdirectory. Contracts (classes that are stored in a 
`Contracts` folder) are not listed.

    <?php return array (
      'SocialMedia' => 
      array (
        'Dropbox' => 
        array (
          0 => 'Pletfix\\OAuth\\Drivers\\SocialMedia\\Dropbox',
        ),
        'Facebook' => 
        array (
          0 => 'Pletfix\\OAuth\\Drivers\\SocialMedia\\Facebook',
        ),
        'GitHub' => 
        array (
          0 => 'Pletfix\\OAuth\\Drivers\\SocialMedia\\GitHub',
        ),
      ),
    );

So you can read all social media drivers provided by the enabled plugins as follows:

    $drivers = include manifest_path('plugins/drivers.php');
    $socials = isset($drivers['SocialMediaDriver']) ? $drivers['SocialMediaDriver'] : [];
        
<a name="routes"></a>
### 11. Routes

If available, the embedded route entries will be added to the `.manifest/plugins/routes.php` manifest. 
 
    <?php
    
    use Core\Services\Contracts\Route;
    
    $route = \Core\Application::route();
    
    ///////////////////////////////////////////////////////////////////////////////
    // pletfix/hello
    
    $route->get('hello-service', function() {
        return di('hello')->sayHello();
    });
    
    $route->get('hello', 'HelloController@index', 'Hello');
 
When the application is started, the [HTTP router](routing) loads this manifest.
 
You could overwrite this route entries in the application's route file `config/boot/routes.php`.
 
<a name="services"></a>
### 12. Services

If available, the services, provided by the plugin, will be added to the `.manifest/plugins/services.php` manifest.   

    <?php
    
    $di = \Core\Services\DI::getInstance();
    
    ///////////////////////////////////////////////////////////////////////////////
    // pletfix/hello
    
    $di->set('hello', \Pletfix\Hello\HelloService::class, true);

The [Dependency Injector](di) loads this manifest when the application is started. 

You could overwrite this entries in the application's service file `config/boot/swervices.php`.

<a name="bootstraps"></a>
### 13. Bootstraps

If available, the bootstraps, which the plugin includes, will be added to the `.manifest/plugins/bootstrap.php` manifest.   

    <?php
    
    ///////////////////////////////////////////////////////////////////////////////
    // pletfix/hello
    
    (new Pletfix\Hello\Bootstraps\Plugin)->boot();

The application loads this manifest when booting, see also [Lifecycle Web Request](lifecycle#web)

<a name="enable-plugin"></a>
### 14. Enable Plugin
   
Finally, the plugin will be added to the `.manifest/plugins/packages.php` manifest to mark that the plugin has 
been registered successfully. 
   
    <?php return array (
      'pletfix/hello' => 'vendor/pletfix/hello',
    );   
   
   
<a name="writing"></a>
## Writing Plugins
 
If you want to write your own plugin, follow the instructions on <https://github.com/pletfix/hello> to create a
workbench with a fresh plugin skeleton. After this you are ready to add services, assets, commands or what ever you like.  

> If you preferred it, you could use "pletfix-" as prefix and "-plugin" as suffix for the plugin name. This parts are 
> ignored while the registration procedure. 

<div class="method-list" markdown="1">

[Assets](#writing-assets)
[Bootstraps](#writing-bootstraps)
[Commands](#writing-commands)
[Configuration](#writing-configuration)
[Controllers](#writing-controllers)
[Drivers](#writing-drivers)
[Language Files](#writing-language-files)
[Middleware](#writing-middleware)
[Migrations](#writing-migrations)
[Public Files](#writing-public-files)
[Routes](#writing-routes)
[Services](#writing-services)
[Views](#writing-views)

</div>

<a name="writing-assets"></a>
### Assets

You may add assets to the plugin by creating the asset build file under `assets/build.php`.

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-assets/
            |-js/
            |-css/
            |-build.php
</pre>

Read chapter [Assets](assets) to learn how the asset management works. The only difference to the assets of the 
application is that the asset build file is not stored under `resources/assets`, but in your plugin under `assets` 
directory.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> **Convention Notes**
> 
> If possible, you should define a single javascript file and a single stylesheet file with the name of your plugin,
> provided of course, these are needed. For example, the build file of our `hello` plugin looks like below:
> 
>     return [
>        'js/hello.js' => [
>            __DIR__ . '/js/greeting.js',
>        ],
>     ]; 
>
> If your plugin needs multiple files, you can also use subfolders that are named as your plugin. Again, an example 
> with our `hello` plugin:
>
>     return [
>        'css/hello/greeting.css' => [
>            __DIR__ . '/css/how-do-you-do.css',
>            __DIR__ . '/css/good-day.css',
>        ],
>        'css/hello/bye.css' => [
>            __DIR__ . '/css/bye.css',
>        ],
>     ]; 

<a name="writing-bootstraps"></a>
### Bootstraps

If you like to modify the boot process, write a class that inherit from `Bootable` and store the file under the plugin's 
`src/Bootstraps` directory:
 
<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-src/
            |-Bootstraps/
                |-Whatever.php
</pre>

The class implements a `boot` method that is executed while booting.

    namespace Core\Bootstraps;
    
    use Core\Services\DI;
    use Core\Bootstraps\Contracts\Bootable;
    
    class WhatEver implements Bootable
    {
        /**
         * Bootstrap
         */
        public function boot()
        {
            // add code here 
        }
    }

<a name="writing-commands"></a>
### Commands

You may also add commands to your plugin. The right place for the class files is `src/Commands`:

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-src/
            |-Commands/
                |-WhateverCommand.php
</pre>

Read chapter [Commands](commands) to learn how you write commands.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> **Convention Notes**
> To avoid naming conflicts with other plugins, you should use a command group named like your plugin.
> For example, our `hello` plugin includes a command `hello:greeting` which you can execute with the following command:
>
> 	php console hello:greeting
>

<a name="writing-configuration"></a>
### Configuration

Of course, you can configure your plugin in a similar way as the application itself. Save the plugin's configuration 
under `config/config.php`:

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-config/
            |-config.php
</pre>

The [registration procedure](#registering) copies the file into the `config` directory under the name of the plugin.

Read chapter [Configuration](configuration) to learn more about configuration and environment variables.  

<a name="writing-controllers"></a>
### Controllers

Add your controllers into the plugin's `src/Controllers` directory: 

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-src/
            |-Controllers/
               |-MyController.php
</pre>

Read chapter [Controllers](controllers) to learn how you write controllers.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> **Convention Notes**
> You should choose meaningful class names so the controller could be specified into the routes without the full namespace. 
> As long as it is unique within the application, you can reference the controller with the name without "My-Vender/My-Plugin/Controllers/" portion. 
> If your plugin uses only one controller, you could use the name of the plugin as a prefix of the controller name. 
> For example, our `hello` plugin provides the controller `Pletfix\Hello\Controllers\HelloController.php`.	
			
<a name="writing-drivers"></a>
### Drivers

If you like to provide drivers for a factory, create a subdirectory under `src/Drivers` to group the types of the driver
and store the driver classes into them.

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-src/
            |-Drivers/
               |-MyDriverType/
                  |-MyDriver.php
</pre>
					     		     
<a name="writing-language-files"></a>
### Language Files

If the plugin have to translate something, save the language files under the plugins `lang` folder like this:  
 
<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-lang/
            |-de.php
            |-en.php
</pre>

Note that the file structure is different from the application's language file structure, but the structure of the 
language file itself does not differ.

<a name="writing-middleware"></a>
### Middleware

You may also add middleware to your plugin. The right place for the class files is `src/Middleware`:

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-src/
            |-Middleware/
               |-MyMiddleware.php
</pre>

Read chapter [Middleware](middleware) to learn how you write your own middleware.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> **Convention Notes**
> You should choose meaningful class names so the middleware could be specified into the routes without the full namespace. 
> Remember, as long as it is unique within the application, you can reference the middleware with the name without 
> "My-Vender/My-Plugin/Middleware/" portion. 
> If your plugin uses only one middleware, you could use the name of the plugin as the middleware name. 
> For example, our `hello` plugin provides the middleware `Pletfix\Hello\Middleware\Hello.php`.	

<a name="writing-migrations"></a>
### Migrations

Does your plugin need an own database table? No problem, add a migration file to the plugin under the `migrations` 
folder.
 
<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-migrations/
            |-20170204121100_CreateWhatever.php
</pre>

The structure of the migration file corresponds to the application's [migration file](migrations).      

<a name="writing-public-files"></a>
### Public Files

Put all things, that finally should be placed in the applications `public` folder, into the `public` folder of your 
plugin.
 
<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-public/     
</pre>

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i> 
> **Convention Notes**
> To avoid naming conflicts with other plugins, you should use subfolders with the name of your plugin to store your files.
> For example, our `hello` plugin stores an image `key.gif` into the folder `public/images/hello`.

<a name="writing-routes"></a>
### Routes

Add default route entries to the plugin's `config/routes.php` file.

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-config/
            |-routes.php
</pre>

Read chapter [HTTP Routing](routing) for details on routing.

<a name="writing-services"></a>
### Services

You should set the services, which are provided by the plugin, into the [Dependency Injection Container](di). 
As like the services of the application, you may register the services in the Plugin's `config/services.php` file.

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-config/
            |-services.php
</pre>

Note, the Dependency Injection entries of the plugin could be overwritten by the application's `config/boot/services.php`. 

<a name="writing-views"></a>
### Views

If your plugin needs views, add the templates into the `view` folder under the plugin.

<pre class="tree">
|-workbench/
   |-my-vendor/
      |-my-plugin/
         |-views/
            |-my-view.blade.php
</pre>


<a name="deploying"></a>
## Deploying Plugins

When you have finished your plugin, you can submit it on [Packagist](https://packagist.org/) to share with the community.
Do not forget to set the keyword "pletfix" in the `composer.json`file so that the plugin is automatically listed on the 
[Pletfix plugin page](https://pletfix.com/plugins).

    "keywords": ["pletfix", "plugin"],

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Don't forget to [test](testing) before uploading the plugin. 
