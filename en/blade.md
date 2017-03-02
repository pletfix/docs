# Blade Templates

_Lightweight and Simplified kind of Laravel's Blade Template_

[Since 0.5.0]

- [Introduction](#introduction)
- [Usage](#usage)
    - [Defining A Layout](#defining)
    - [Extending A Layout](#extending)
    - [Including Partials](#including)
    - [Displaying Data](#displaying-data)
    - [Control Structures](#control-structures)
    - [Embedded PHP](#php)
    - [Comments](#comments)
- [Extending Blade](#extending-blade)
- [Quick Reference](#quick-reference)
    - [Displaying Data](#quick-displaying)
    - [Masking](#quick-masking)
    - [Extending a Layout](#quick-extending)
    - [Sections](#quick-sections)
    - [Including Partials](#quick-including)
    - [If Statements](#quick-if)
    - [Loops](#quick-loops)
    - [User Ability Check](#quick-check)
    - [Embedded PHP](#quick-php)
    - [Not supported Commands](#quick-not-supported)

> The Pletfix ViewCompiler based on [Laravel's Blade Compiler](https://github.com/illuminate/view/blob/5.3/Compilers/BladeCompiler.php)
> and therefore this manual based on the original Documentation of [Laravel's Blade Templates](https://github.com/laravel/docs/blob/5.3/blade.md).
> It's open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
>
> Thank's [Taylor Otwell](https://github.com/taylorotwell) for his grateful work!

<a name="introduction"></a>
## Introduction

Pletfix provides a simplified kind of Blade Template, a powerful templating engine by Laravel.  

Unlike other popular PHP templating engines, Blade does not restrict you from using plain PHP code in your views. 
In fact, all Blade views are compiled into plain PHP code and cached until they are modified, meaning Blade adds 
essentially zero overhead to your application. 

Blade view files use the `.blade.php` file extension and are typically stored in the `resources/views` directory.

The views will be compiled automatically on the first rendering. The compiled views are cached in `storage/cache/views` directory.

<a name="usage"></a>
## Usage

<a name="defining"></a>
### Defining A Layout

Two of the primary benefits of using Blade are _template inheritance_ and _sections_. To get started, let's take a look 
at a simple example. First, we will examine a "master" page layout. Since most web applications maintain the same general 
layout across various pages, it's convenient to define this layout as a single Blade view:

    <!-- Stored in resources/views/layouts/app.blade.php -->

    <html>
        <head>
            <title>App Name - @yield('title')</title>
        </head>
        <body>
            @section('sidebar')
                This is the master sidebar.
            @show

            <div class="container">
                @yield('content')
            </div>
        </body>
    </html>

As you can see, this file contains typical HTML mark-up. However, take note of the `@section` and `@yield` directives. 
The `@section` directive, as the name implies, defines a section of content, while the `@yield` directive is used to 
display the contents of a given section.

Now that we have defined a layout for our application, let's define a child page that inherits the layout.

<a name="extending"></a>
### Extending A Layout

When defining a child view, use the Blade `@extends` directive to specify which layout the child view should "inherit". 
Views which extend a Blade layout may inject content into the layout's sections using `@section` directives. Remember, 
as seen in the example above, the contents of these sections will be displayed in the layout using `@yield`:

    <!-- Stored in resources/views/child.blade.php -->

    @extends('layouts.app')

    @section('title', 'Page Title')

    @section('sidebar')
        @@parent

        <p>This is appended to the master sidebar.</p>
    @endsection

    @section('content')
        <p>This is my body content.</p>
    @endsection

In this example, the `sidebar` section is utilizing the `@@parent` directive to append (rather than overwriting) content 
to the layout's sidebar. The `@@parent` directive will be replaced by the content of the layout when the view is rendered.

Blade views may be returned from routes using the global `view` helper:

    Route::get('blade', function () {
        return view('child');
    });

<a name="including"></a>
### Including Partials

Blade's `@include` directive allows you to include a Blade view from within another view. All variables that are available 
to the parent view will be made available to the included view:

    <div>
        @include('shared.errors')

        <form>
            <!-- Form Contents -->
        </form>
    </div>

Even though the included view will inherit all data available in the parent view, you may also pass an array of extra 
data to the included view:

    @include('view.name', ['some' => 'data'])

> You should avoid using the `__DIR__` and `__FILE__` constants in your Blade views, since they will refer to the 
> location of the compiled view.
    
<a name="displaying-data"></a>
### Displaying Data

You may display data passed to your Blade views by wrapping the variable in curly braces. For example, given the 
following route:

    Route::get('greeting', function () {
        return view('welcome', ['name' => 'Samantha']);
    });

You may display the contents of the `name` variable like so:

    Hello, {{ $name }}.

Of course, you are not limited to displaying the contents of the variables passed to the view. You may also echo the 
results of any PHP function. In fact, you can put any PHP code you wish inside of a Blade echo statement:

    The current UNIX timestamp is {{ time() }}.

> Blade `{{ }}` statements are automatically sent through PHP's `htmlentities` function to prevent XSS attacks.

#### Echoing Data If It Exists

Sometimes you may wish to echo a variable, but you aren't sure if the variable has been set. We can express this in 
verbose PHP code like so:

    {{ isset($name) ? $name : 'Default' }}

However, instead of writing a ternary statement, Blade provides you with the following convenient shortcut, which will 
be compiled to the ternary statement above:

    {{ $name or 'Default' }}

In this example, if the `$name` variable exists, its value will be displayed. However, if it does not exist, the word 
`Default` will be displayed.

#### Displaying Unescaped Data

By default, Blade `{{ }}` statements are automatically sent through PHP's `htmlentities` function to prevent XSS attacks. 
If you do not want your data to be escaped, you may use the following syntax:

    Hello, {!! $name !!}.

> Be very careful when echoing content that is supplied by users of your application. 
> Always use the escaped, double curly brace syntax to prevent XSS attacks when displaying user supplied data.

#### Escape Blade Directive 

Since many JavaScript frameworks also use "curly" braces to indicate a given expression should be displayed in the browser, 
you may use the `@` symbol to inform the Blade rendering engine an expression should remain untouched. For example:

    <h1>Laravel</h1>

    Hello, @{{ name }}.

In this example, the `@` symbol will be removed by Blade; however, `{{ name }}` expression will remain untouched by the 
Blade engine, allowing it to instead be rendered by your JavaScript framework.

<a name="control-structures"></a>
### Control Structures

In addition to template inheritance and displaying data, Blade also provides convenient shortcuts for common PHP control 
structures, such as conditional statements and loops. These shortcuts provide a very clean, terse way of working with 
PHP control structures, while also remaining familiar to their PHP counterparts.

#### If Statements

You may construct `if` statements using the `@if`, `@elseif`, `@else`, and `@endif` directives. These directives function 
identically to their PHP counterparts:

    @if (count($records) === 1)
        I have one record!
    @elseif (count($records) > 1)
        I have multiple records!
    @else
        I don't have any records!
    @endif

#### Loops

In addition to conditional statements, Blade provides simple directives for working with PHP's loop structures. Again, 
each of these directives functions identically to their PHP counterparts:

    @for ($i = 0; $i < 10; $i++)
        The current value is {{ $i }}
    @endfor

    @foreach ($users as $user)
        <p>This is user {{ $user->id }}</p>
    @endforeach

    @while (true)
        <p>I am looping forever.</p>
    @endwhile

When using loops you may also end the loop or skip the current iteration:

    @foreach ($users as $user)
        @if ($user->type == 1)
            @continue
        @endif

        <li>{{ $user->name }}</li>

        @if ($user->number == 5)
            @break
        @endif
    @endforeach

You may also include the condition with the directive declaration in one line:

    @foreach ($users as $user)
        @continue($user->type == 1)

        <li>{{ $user->name }}</li>

        @break($user->number == 5)
    @endforeach

<a name="php"></a>
### Embedded PHP

In some situations, it's useful to embed PHP code into your views. You can use the Blade `@php` directive to execute a 
block of plain PHP within your template:

    @php
        //
    @endphp

> While Blade provides this feature, using it frequently may be a signal that you have too much logic embedded 
within your template.

<a name="comments"></a>
### Comments

Blade also allows you to define comments in your views. However, unlike HTML comments, Blade comments are not included 
in the HTML returned by your application:

    {{-- This comment will not be present in the rendered HTML --}}

<a name="extending-blade"></a>
## Extending Blade

Not implemented yet, planned in future.

<!--
Blade allows you to define your own custom directives using the `directive` method. When the Blade compiler encounters 
the custom directive, it will call the provided callback with the expression that the directive contains.

The following example creates a `@datetime($var)` directive which formats a given `$var`, which should be an instance 
of `DateTime`:

    <?php

    namespace App\Providers;

    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Perform post-registration booting of services.
         *
         * @return void
         */
        public function boot()
        {
            Blade::directive('datetime', function ($expression) {
                return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
            });
        }

        /**
         * Register bindings in the container.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    }

As you can see, we will chain the `format` method onto whatever expression is passed into the directive. So, in this example, the final PHP generated by this directive will be:

    <?php echo ($var)->format('m/d/Y H:i'); ?>

> After updating the logic of a Blade directive, you will need to delete all of the cached Blade views in 
`storage/cache/views` directory.
-->

<a name="quick-reference"></a>
## Quick Reference

<a name="quick-displaying"></a>
### Displaying Data
<pre>
{{ $var }}                      - Echo escaped content
{!! $var !!}                    - Echo raw content
{{-- Comment --}}               - A Blade comment
{{ $var or 'default' }}         - Echo escaped content with a default value
{!! $var or 'default' !!}       - Echo raw content with a default value
</pre>

<a name="quick-masking"></a>
### Masking
<pre>
@{{ $var }}                     - Initiates HTML code ("@" will be skipped)
@{!! $var !!}                   - Initiates HTML code ("@" will be skipped)
@@anyexpression                 - Initiates HTML code (the first "@" will be skipped)
</pre>

<a name="quick-extending"></a>
### Extending a Layout
<pre>
@extends('layout')              - Extends a template with a layout
</pre>

<a name="quick-sections"></a>
### Sections
<pre>
@yield('section')               - Yields content of a section
@yield('section', 'default')    - Yields content of a section with a default value
@section('name', 'content')     - Section
@section('name')                - Starts a section block
@endsection                     - Ends section block
&#64;@parent                         - Include the parent section (allowed only within a section) 
</pre>

<a name="quick-including"></a>
### Including Partials
<pre>
@include('view')                - Includes a partial view
@include('view', $vars)         - Includes a partial view with additional variables.
</pre>

<a name="quick-if"></a>
### If Statements
<pre>
@if(condition)                  - Starts an if block
@else                           - Starts an else block
@elseif(condition)              - Start an elseif block
@endif                          - Ends an if block
</pre>

<a name="quick-loops"></a>
### Loops
<pre>
@for($i = 0; $i &lt; 10; $i++)     - Starts a for block
@endfor                         - Ends a for block
@foreach($list as $val)         - Starts a foreach block
@foreach($list as $key => $val) - Starts a foreach block with key
@endforeach                     - Ends a foreach block
@while(condition)               - Starts a while block
@endwhile                       - Ends a while block
@continue                       - Skip the current iteration (allowed only within a loop)
@continue(condition)            - Skip the current iteration if the condition is true (allowed only within a loop)
@break                          - Break the current iteration (allowed only within a loop)
@break(condition)               - Break the current iteration if the condition is true (allowed only within a loop)
</pre>

<a name="quick-check"></a>
### User Ability Check
<pre>
@can($ability)                  - Starts a block if the current user have the given ability
@elsecan($ability)              - Starts an else block if the current user have the given ability
@elsecan                        - Starts an else block
@endcan                         - Ends an can block
@cannot($ability)               - Starts a block if the current user have not the given ability
@elsecannot($ability)           - Starts an else block if the current user have not the given ability
@elsecannot                     - Starts an else block
@endcannot                      - Ends an cannot block
</pre>

<a name="quick-php"></a>
### Embedded PHP
<pre>
@php                            - Starts a block of PHP code
@endphp                         - Ends PHP code
</pre>

<a name="quick-not-supported"></a>
### Not supported Laravel's Blade Commands 5.3
<pre>
@each (Rendering Collections)
@forelse, @endforelse, @empty
@includeIf
@inject (Service Injection)
$loop (Loop variables)
@push, @endpush (Stacks)
@unless, @endunless
@verbatim, @endverbatim
Extending Blade (planned in future)
</pre>
