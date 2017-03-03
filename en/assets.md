# Asset Management

_Work with images, scripts, CSS files_

[Since 0.5.0]

- [Introduction](#introduction)
- [Asset Build Definition](#definition)
- [Publishing the Assets](#publishing)
    - [JavaScript](#scripts)
    - [Stylesheets](#stylesheets)
    - [Copying Files & Directories](#copying)
- [Versioning / Cache Busting](#versioning)
- [Usage in the View](#usage)

<a name="introduction"></a>
## Introduction

Pletfix provide a simple asset pipeline tool to published your Stylesheets, JavaScripts and other assets.

Under the hood, Pletfix uses the following tools:

- Javascript Minifier: [JShrink](https://github.com/tedious/JShrink) by Robert Hafner, licensed under [BSD License](https://github.com/tedious/JShrink/blob/master/LICENSE).
- Stylesheet Minifier: [Clone of CssMin](https://github.com/natxet/cssmin). The original [CssMin](https://code.google.com/archive/p/cssmin/) by Joe Scylla is licensed under [MIT License](https://opensource.org/licenses/mit-license.php).
- Less Compiler: [Less.php](https://github.com/oyejorge/less.php), a PHP port of the official [LESS processor](http://lesscss.org), licensed under [Apache License](https://github.com/oyejorge/less.php/blob/master/LICENSE).
- SCSS Compiler: [scssphp](http://leafo.github.io/scssphp/) by Leaf Corcoran, licensed under [MIT License](https://raw.githubusercontent.com/leafo/scssphp/master/LICENSE.md). See also [scssphp on GitHub](https://github.com/leafo/scssphp).

<a name="definition"></a>
## Asset Build Definition

You may define your assets in `resources/assets/build.php`. It's look like so:

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

If you would like minify one or more javascript files or just combine them into a single file, you can define it like so: 

    'path/to/dest.min.js' => [
        'path/to/source.js',
        'path/to/second-script.js',
        'path/to/folder',
    ],

The destination file on the left site must have `.js` as file extension. The source list on the right site 
could contain JavaScript files and folders. Files which are in the folder that are not a JavaScript file will be ignored.  

<a name="stylesheets"></a>
### Stylesheets

If you would like to minify and combine some stylesheets to a single file, you may use it as below: 

    'path/to/dest.min.css' => [
        'path/to/source.css',
        'path/to/scss-file.scss',
        'path/to/less-file.less',
        'path/to/folder',
    ],

Note that the destination file on the left site must have `.css` as file extension and the source list on the right site 
could contain CSS, SCSS, Less files and folders. Only stylesheet files are substantial in the folder.

<a name="copying"></a>
### Copying Files & Directories

If you like to simple copy some files to the `public` folder, write entries in `resources/assets/build.php` like this: 

        'subpath' => [
            'path/to/a/image.png',
            'path/to/readme.md',
            'path/to/folder'
        ],

Note the destination is a folder. In this case all files and directories on the right site will be copied into the
destination folder instead of concatenate it to a single file

Of course, it's also possible to concatenate some non-JS files and non-CSS to a single file.

<a name="publishing"></a>
## Publishing the Assets

You may enter the following Pletfix command in your terminal to build all the assets you have defined:

    php console asset
    
If you like to build just one specified asset, set the name of the destination file:
     
    php console asset css/app.css  

The Pletfix's `asset` command is doing the following steps:

1. **Compiling**: If the source file a SCSS or Less File, the `asset` command will compile this to a plain CSS file.
2. **Minimizing** JavaScript and stylesheets will be minimized so that it can be delivered to the client quicker.
3. **Concatenation**: If the destination not a folder rather a file, `asset` will concatenate the minimizing files to a single file.    
4. **Copy**: Finally `asset` will copy the concatenate file or the original source files to the public folder under the destination.
5. **Cache Busting**: TODO

<a name="versioning-and-cache-busting"></a>
## Versioning / Cache Busting

Many developers suffix their compiled assets with a timestamp or unique token to force browsers to load the fresh assets 
instead of serving stale copies of the code. The Pletfix `asset` handle this for you automatically.

TODO 

The `version` method will automatically append a unique hash to the filenames of all compiled files, allowing for more convenient cache busting:

<a name="usage"></a>
## Usage in the View

TODO 

After generating the versioned file, you won't know the exact file name. 
So, you should use the global helper function `asset()` to load the appropriately hashed asset into the view.
The `asset()` function will automatically determine the current name of the hashed file:

    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
