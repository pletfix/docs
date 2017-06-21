# Plugins

_Extending the core_

[Since 0.5.0]

- [Introduction](#introduction)
- [Installing Plugins](#installing)
    - [Downloading](#downloading)
    - [Registering](#registering)
    - [Updating](#updating)
    - [Removing](#removing)
- [Writing Plugins](#writing)
- [Deploying Plugins](#deploying)
    
<a name="introduction"></a>
## Introduction

Postfix offers a powerful plugin system, which allows you to expand your application quickly by other features that 
the community has developed. Of course, you can also develop plugins themselves and provide the community.

You will see that this is not very complicated.

<a name="installing"></a>
## Installing Plugins

<a name="downloading"></a>
### Downloading

Like the Pletfix Application, a Pletfix plugin is also a [Composer](https://getcomposer.org/) package. So it can be 
installed the same way. 

For example, let's install the actual useless Pletfix `Hello` plugin as below:
    
1. We have not deployed our `Hello` plugin on [Packagist](https://packagist.org/), the Composers default package archive.
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

For example, enter this command in your terminal to register our `Hello` plugin:

    php console plugin pletfix/hello 
 
> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> The help screen of the `plugin` command lists all enabled packages. 
>
>      php console plugin --help
             
#### Registration Procedure
	
If you register a plugin, the following things will happen:
 
1. **Publish configuration**

   If available and if not already done, the configuration file of the plugin will be copied into the `config` directory.
   For example, for our `Hello` plugin, the filename would be` hello.php`.
   
   > The configuration file will be not updated if it already exists.
   
2. **Publish `public` folder**

    If available, public files of the plugin will be copied into the application's public folder. 

3. **Publish assets**

    If available, the asset build file of the plugin will be added to the `.manifest/plugins/assets.php` manifest.
    After this the `AssetManager` publishes the assets of the plugin. 
    For example, our `Hello` plugin provides a `hello.js` script which will be published to `public/js/hello.js`.

    You may repeat publishing the assets manually if you enter this command in a terminal:   
    
       php console asset --plugin=hello 

4. **Publish commands**

   If available, the commands embedded in the plugin will be added to the `.manifest/plugins/commands.php` manifest.   
   The command factory reads this manifest if you enter `php console` to list all files.
    
5. **Publish migration files**

   If available, the migration files embedded in the plugin will be added to the `.manifest/plugins/migrations.php` manifest.   
   This manifest will be read if you [run the migration](migrations#running).

6. **Publish language files**

    If available, the language files of the plugin will be added to the `.manifest/plugins/lang` manifest.
    Pletfix loads this manifest for translating. 

7. **Publish views**

    If available, the path of the plugin's views will be added to the `.manifest/plugins/views.php` manifest.
    Pletfix needs this manifest to find the template for rendering.

8. **Publish routes**

   If available, the embedded route entries will be added to the `.manifest/plugins/routes.php` manifest.   
   When the application is started, the [HTTP router](routing) loads this manifest.
   
4. **Publish classes**

   All classes that stored in a subdirectory under the plugin's `./src` directory will be added to the 
   `.manifest/plugins/classes.php` manifest, grouped to the top subdirectory. This is useful to add classes for specific 
   use cases, such like controllers or middleware classes. Classes that stored directly into `./src` directory (without 
   subdirectory) or into the subdirectory 'Bootstraps', 'Commands' or 'Services', are not added to this manifest. 
   Contracts (classes that are stored in a `Contracts` folder) are not listed too.
   
   For example, you have the following classes:   
   
       <pre class="tree">
       |-workbench/
          |-your-vendor/
             |-your-pluging/
                |-src/
                   |-Controllers/
                   |  |-YourController.php
                   |-Middleware/
                   |  |-YourMiddleware.php
            
       </pre>

   The `.manifest/plugins/classes.php` file looks like this:
    
       <?php return array (
         'Controllers' => 
         array (
           'YourController' => 'Pletfix\\YourPlugin\\Controllers\\YourController',
         ),
         'Middleware' => 
         array (
           'YourMiddleware' => 'Pletfix\\YourPlugin\\Middleware\\YourMiddleware',
         ),
       );

   As an example, you can now define all the controls provided by plugins, like this:
    
        $classes = include manifest_path('plugins/classes.php');
        $controllers = isset($classes['Controllers']) ? $classes['Controllers'] : [];
   
9. **Publish services**

   If available, the services, provided by the plugin, will be added to the `.manifest/plugins/services.php` manifest.   
   The [Dependency Injector](di) loads this manifest when the application is started. 

10. **Publish bootstraps**

   If available, the bootstraps, which the plugin includes, will be added to the `.manifest/plugins/bootstrap.php` manifest.   
   The application loads this manifest when booting, see also [Lifecycle Web Request](lifecycle#web)
   
11. **Enable Package**
        
   Finally, the plugin will be added to the `.manifest/plugins/packages.php` manifest to mark that the plugin has 
   been registered successfully.   
        
<a name="updating"></a>        
### Updating

If the plugin is already installed, you cannot install it once more. But you can use the `--update` option to update 
the manifest files, for our `Hello` plugin like so:

    php console plugin pletfix/hello --update        
      
<a name="removing"></a>            
### Removing

Use the `--remove` option to unregister the plugin. Again the example with our `Hello` plugin:

    php console plugin pletfix/hello --remove 
    
> The plugin package remains in the vendor directory. So you can register the plugin at any time again.         
            
<a name="writing"></a>
## Writing Plugins
 
If you want to write your own plugin, follow the instructions on <https://github.com/pletfix/hello> to create a
workbench with a fresh plugin skeleton. After this you are ready to add services, assets, commands or what ever you like.  

<div class="method-list" markdown="1">

[Assets](#assets)
[Bootstraps](#bootstraps)
[Commands](#commands)
[Configuration](#configuration)
[Controllers](#controllers)
[Language Files](#language-files)
[Middleware](#middleware)
[Migrations](#migrations)
[Public Folder](#public-folder)
[Routes](#routes)
[Services](#services)
[Views](#views)

</div>

<a name="assets"></a>
### Assets

You may add assets to the plugin by creating the asset build file under `assets/build.php`.

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-assets/
            |-js/
            |-css/
            |-build.php
</pre>

Read chapter [Assets](assets) to learn how the asset management works. The only difference to the assets of the 
application is that the asset build file is not stored under `resources/assets`, but in your plugin under `assets` 
directory.

<a name="bootstraps"></a>
### Bootstraps

If you like to modify the boot process, write a class that inherit from `Bootable` and store the file under the plugin's 
`src/Bootstraps` directory:
 
<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
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

<a name="commands"></a>
### Commands

You may also add commands to your plugin. The right place for the class files is `src/Commands`:

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-src/
            |-Commands/
                |-WhateverCommand.php
</pre>

Read chapter [Commands](commands) to learn how you write commands.

<a name="configuration"></a>
### Configuration

Of course, you can configure your plugin in a similar way as the application itself. Save the plugin's configuration 
under `config/config.php`:

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-config/
            |-config.php
</pre>

The [registration procedure](#registering) copies the file into the `config` directory under the name of the plugin.

Read chapter [Configuration](configuration) to learn more about configuration and environment variables.  

<a name="controllers"></a>
### Controllers

Add your controllers into the plugin's `src/Controllers` directory: 

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-src/
            |-Controllers/
                |-YourController.php
</pre>

Read chapter [Controllers](controllers) to learn how you write controllers.

<a name="language-files"></a>
### Language Files

If the plugin have to translate something, save the language files under the plugins `lang` folder like this:  
 
<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-lang/
            |-de.php
            |-en.php
</pre>

Note that the file structure is different from the application's language file structure, but the structure of the 
language file itself does not differ.

<a name="middleware"></a>
### Middleware

You may also add middleware to your plugin. The right place for the class files is `src/Middleware`:

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-src/
            |-Middleware/
                |-YourMiddleware.php
</pre>

Read chapter [Middleware](middleware) to learn how you write your own middleware.

<a name="migrations"></a>
### Migrations

Does your plugin need an own database table? No problem, add a migration file to the plugin under the `migrations` 
folder.
 
<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-migrations/
            |-20170204121100_CreateWhatever.php
</pre>

The structure of the migration file corresponds to the application's [migration file](migrations). 
   
Note, that the migration won't run automatically. You have to execute the `migrate` command after the registration procedure:
 
    php console migrate
     

<a name="public-folder"></a>
### Public Folder

Put all things, that finally should be placed in the applications `public` folder, into the `public` folder of your plugin.
 
<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-public/
            |-images/
                |-whatever.png       
</pre>

<a name="routes"></a>
### Routes

Add default route entries to the plugin's `config/routes.php` file.

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-config/
            |-routes.php
</pre>

Note, the default routes of the plugin could be overwritten by the application's `config/boot/routes.php` file. 

Read chapter [HTTP Routing](routing) for more details on routing.

<a name="services"></a>
### Services

You should set the services, which are provided by the plugin, into the [Dependency Injection Container](di). 
As like the services of the application, you may register the services in the Plugin's `config/services.php` file.

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-config/
            |-services.php
</pre>

Note, the Dependency Injection entries of the plugin could be overwritten by the application's `config/boot/services.php`. 

<a name="views"></a>
### Views

If your plugin needs views, add the templates into the `view` folder under the plugin.

<pre class="tree">
|-workbench/
   |-your-vendor/
      |-your-pluging/
         |-views/
            |-your-view.blade.php
</pre>

Your embedded view will be overwritten, if the view is stored with the same name in the application's `resources/view` 
folder as below:

<pre class="tree">
|-your-app/
   |-resources/
      |-views/
         |-your-view.blade.php
</pre>


<a name="deploying"></a>
## Deploying Plugins

When you have finished your plugin, you can upload it on [Packagist](https://packagist.org/) to share with the community.

It is also a good idea to add an entry on the [Pletfix plugin page](../../../plugins).

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Don't forget to [test](testing) before uploading the plugin. 
