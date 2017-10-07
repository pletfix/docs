# Localization

_Make a multilingual site._

- [Introduction](#introduction)
- [Basic Configuration](#configuration)
- [Translation Files](#files) 
    - [Usage](#usage)
    - [Placeholders](#placeholders)
- [Build a Multilingual Site](#multilingual)

<a name="introduction"></a>
## Introduction

Pletfix's localization features provide a convenient way to retrieve strings in various languages, allowing you to 
easily support multiple languages within your application. 

<a name="configuration"></a>
## Basic Configuration

The default language for your application is stored in the configuration file `config/locale.php`:

    'default' => 'de',

Use the two-letter language code according to [ISO 639-1](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes).
     
You may also configure a fallback language, which will be used when the active language does not contain a given 
translation string: 

    'fallback' => 'en',
   
<a name="files"></a>
## Translation Files

The Translation files are stored in the `resources/lang` directory. Within this directory there should be a 
subdirectory for each language supported by the application:

<pre class="tree">
|-resources/
   |-lang/
   |  |-de/
   |  |  |-messages.php
   |  |-en/
   |  |  |-messages.php
</pre>

All language files simply return an array of keyed strings. For example:

    return [
        'welcome' => 'Welcome to our application',
    ];

<a name="usage"></a>
### Usage

You may retrieve lines from language files using the `t()` helper function. 
The function expects the file and the key of the translation string as argument: 

For example, let's retrieve the `welcome` translation string from the `resources/lang/messages.php` language file:

    echo t('messages.welcome');
    
The same example in a [Blade Template](blade):
    
    {{t('messages.welcome')}}

If the specified translation string does not exist, `t()` will simply return the translation string key. 

<a name="placeholders"></a>
### Placeholders

The translation strings may contain placeholders in the form `{foo}`:

For example, you may define a welcome message with a place-holder name:

    'welcome' => 'Welcome, {name}',

To replace the placeholders when retrieving a translation string, pass an array of replacements as the second argument 
to the `t()` function:

    echo t('messages.welcome', ['name' => 'Frank']);

<a name="multilingual"></a>
## Build a Multilingual Site

Follow this steps if you like to provide a multilingual site:
  
1. Define the supported languages in `config/locale.php`:
      
        'supported' => [
            'de' => 'Deutsch',
            'en' => 'English',
            'fr' => 'Français',
            'it' => 'Italiano',
        ],

    Use the two-letter language code as key and the native name as value according to 
    [ISO 639-1](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes).  
    
2. Add a link to your layout so the user can choose his preferred language:

        @foreach(config('locale.supported') as $locale => $name)
            <li><a href="{{locale_url($locale)}}">{{$name}}</a></li>
        @endforeach
        
    Note that the [`locale_url`](helpers#method-locale-url) function prefixes the path of the current URL with the given 
    language code. Suppose the current request is `https:\\example.com\whatever`, the function would be generate 
    `https:\\example.com\en\whatever` as link switching to English. 
  
3. Prefix the route paths in `boot/rootes.php` with the language code. The most elegant way to do this is to 
    dynamically generate the prefix from the current request :
                                                    
        $route->prefix(is_supported_locale(request()->segment(0)) ? request()->segment(0) : null);   
    
    This expression prefixes all the routes for each supported language, in addition to the original definition.    
    
4. Lastly, you need a middleware that reads the language code from the request and saves it in a cookie.
    Therefore, add this into your route file `boot/rootes.php` :
                               
        $route->middleware('locale');
        
Now the user could switch the language for each page! Thanks to the cookie, the selected language is still active even 
if no language code has been entered in the request.

With the `locale` helper function you can determine the active language:

    $locale = locale();

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i> 
> Importend for SEO - Search Engine Optimizing
>
> Since your page is now accessible via more than one unique URL (both with and without country code), you should use 
> the following entry in your layout to tell a search engine like Google which is your preferred URL:  
>         
>     <link rel="canonical" href="@yield('canonical-url', canonical_url())"/>
>        
> Furthermore, you should also tell which languages are available for the displayed content:
>
>     @foreach(config('locale.supported') as $locale => $name)
>         @if(locale() != $locale)
>             <link rel="alternate" hreflang="{{$locale}}" href="{{locale_url($locale)}}"/>
>         @endif
>     @endforeach
