# Asset Management

_Work with images, scripts, CSS files_

[Since 0.5.0]

- [Introduction](#introduction)
- [Asset Build Definition](#definition)
    - [JavaScript](#scripts)
    - [Stylesheets](#stylesheets)
    - [Copying Files & Directories](#copying)
- [Publishing Assets](#publishing)    
- [Removing Assets](#removing)
- [Plugin Options](#plugin)
- [Usage in the View](#usage)

<a name="introduction"></a>
## Introduction

Pletfix provides a simple asset pipeline tool to publish your stylesheets, JavaScripts and other assets.

You may define your assets very easy in `resources/assets/build.php` and publish them with Pletfix command `asset`. 
The command will compile, minimize and concatenate the assets, store it into the `public` folder and suffix 
a unique token to the filename for Cache Busting.

Under the hood Pletfix uses the following tools:

- Javascript Minifier: [JShrink](https://github.com/tedious/JShrink) by Robert Hafner, licensed under [BSD License](https://github.com/tedious/JShrink/blob/master/LICENSE).
- Stylesheet Minifier: [Clone of CssMin](https://github.com/natxet/cssmin). The original [CssMin](https://code.google.com/archive/p/cssmin/) by Joe Scylla is licensed under [MIT License](https://opensource.org/licenses/mit-license.php).
- Less Compiler: [Less.php](https://github.com/oyejorge/less.php) by Josh Schmidt, a PHP port of the official [LESS processor](http://lesscss.org), licensed under [Apache License](https://github.com/oyejorge/less.php/blob/master/LICENSE).
- SCSS Compiler: [scssphp](http://leafo.github.io/scssphp/) by Leaf Corcoran, licensed under [MIT License](https://raw.githubusercontent.com/leafo/scssphp/master/LICENSE.md). See also [scssphp on GitHub](https://github.com/leafo/scssphp).

<a name="definition"></a>
## Asset Build Definition

You may define your assets in `resources/assets/build.php`. It looks like this:

    return [
        'js/app.js' => [
            vendor_path('npm-asset/jquery/dist/jquery.min.js'),
            vendor_path('npm-asset/bootstrap/dist/js/bootstrap.min.js'),
            resource_path('assets/js/base.js'),
        ],
        'css/app.css' => [
            resource_path('assets/less/base.less'),
        ],
        'fonts' => [
            vendor_path('npm-asset/bootstrap/dist/fonts'),
            resource_path('assets/fonts/fonts.gstatic.com_lato.woff2'),
        ],
    ];
  
Pletfix supports JavaScript, stylesheets and other files like fonts or images which should be published into the 
`public` folder.

<a name="scripts"></a>
### JavaScript

If you would like to minimize one or more JavaScript files or just combine them into a single file, you can define it like this: 

    'path/to/dest.min.js' => [
        'path/to/source.js',
        'path/to/second-script.js',
        'path/to/folder',
    ],

The destination file on the left side is relative to the `public` folder and requires `.js` as file extension. 
The source list on the right side should contain absolute file names of JavaScript and folders. 
Files in the folders which are not JavaScript will be ignored.

<a name="stylesheets"></a>
### Stylesheets

If you would like to minimize and combine some stylesheets to a single file, you may use it as below: 

    'path/to/dest.min.css' => [
        'path/to/source.css',
        'path/to/scss-file.scss',
        'path/to/less-file.less',
        'path/to/folder',
    ],

Note that the destination file on the left side must have `.css` as file extension and the source list on the right side 
should contain CSS, SCSS, Less files and folders. Only stylesheets are substantial in the folder.

<a name="copying"></a>
### Copying Files & Directories

If you like to just copy some files to the `public` folder, write entries in `resources/assets/build.php` like this: 

    'subpath' => [
        'path/to/a/image.png',
        'path/to/readme.md',
        'path/to/folder'
    ],

Note the destination is a folder in this example. In this case all files and directories on the right side will be 
copied into the destination folder instead of being concatenated to a single file.

Of course, it's also possible to concatenate some non-JS files and non-CSS to a single file.

<a name="publishing"></a>
## Publishing Assets

You may enter the following Pletfix command in your terminal to build all assets you have defined:

    php console asset
    
If you like to build just one specified asset, set the name of the destination file:
     
    php console asset css/app.css  

The Pletfix's `asset` command is doing the following steps:

1. **Compiling**: If the source file is a SCSS or Less File, the `asset` command will compile this to a plain CSS file.
2. **Minimizing** JavaScript and stylesheets will be minimized so that it can be delivered quicker to the client.
3. **Concatenation**: If the destination is not a folder but a file, `asset` will concatenate the minimized files to a single file.    
4. **Copy**: Finally `asset` will copy the concatenate file or the original source files to the public folder under the destination.
5. **Cache Busting**: Additional the command suffix the unique token to the filename and store it into `public/build`. 

If you don't like to minimize the file, set the 'no-minify' option:
 
    php console asset css/app.css --no-minify
 
      
<a name="removing"></a>
## Removing Assets
               
If you want to remove an already published asset, enter this in your terminal:
 
    php console asset css/app.css --remove
 
 
<a name="plugin"></a>
## Plugin Options
 
You could compile all assets or only a specific asset from a plugin manually. 
For that, you only have to set the 'plugin' option with the name of the plugin (without vendor):
 
    php console asset css/app.css --plugin=hello
               
You can use the `plugin` option and the `remove` option together to remove all assets of a plugin:
 
    php console asset --remove --plugin=hello
 
> Normally you don't need the `plugin` option to publish or remove the assets because it's happening automatically 
> when you install or remove a plugin with the [Pletfix's plugin command](plugins).


<a name="usage"></a>
## Usage in the View

You may use the global helper `asset()` to load the appropriately hashed asset into the view.
Set the asset file relative to the `public` folder as argument of `asset()`. 
The function will automatically determine the current name of the hashed file:

    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

If no corresponding hashed file exists in `public/build`, the original file will be loaded.