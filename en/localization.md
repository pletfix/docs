# Localization

_Make your application support multiple languages_

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.5.2

- [Introduction](#introduction)
- [Configuration](#configuration)
    - [Changing Localization at Runtime](#runtime)
- [Translation Files](#files) 
- [Usage](#usage)
    - [Placeholders](#placeholders)

<a name="introduction"></a>
## Introduction

Pletfix's localization features provide a convenient way to retrieve strings in various languages, 
allowing you to easily support multiple languages within your application. 

<a name="configuration"></a>
## Configuration

The default language for your application is stored in the `config/app.php` configuration file:

    'locale' => 'de',

You may also configure a fallback language, which will be used when the active language does not contain a given 
translation string: 

    'fallback_locale' => 'en',

<a name="runtime"></a>
### Changing Localization at Runtime

Use the global `locale` function to change the active language at runtime:

    locale('fr');

You may also use the `local` function to determine the current localization:

    $locale = locale();

<a name="files"></a>
## Translation Files

Translation files are stored in the `resources/lang` directory.
Within this directory there should be a subdirectory for each language supported by the application as 
[two-letter language code (ISO 639-1)](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes):

   |-resources/
      |-lang/
      |  |-de/
      |  |  |-messages.php
      |  |-en/
      |  |  |-messages.php

All language files simply return an array of keyed strings. For example:

    return [
        'welcome' => 'Welcome to our application',
    ];

<a name="usage"></a>
## Usage

You may retrieve lines from language files using the `t()` helper function. 
The function expects the file and the key of the translation string as argument: 

For example, let's retrieve the `welcome` translation string from the `resources/lang/messages.php` language file:

    echo t('messages.welcome');
    
The same example in a [Blade Template](blade):
    
    {{ t('messages.welcome') }}

If the specified translation string does not exist, `t()` will simply return the translation string key. 

<a name="placeholders"></a>
### Placeholders

The translation strings may contain placeholders in the form `{foo}`:

For example, you may define a welcome message with a place-holder name:

    'welcome' => 'Welcome, {name}',

To replace the placeholders when retrieving a translation string, pass an array of replacements as the second argument 
to the `t()` function:

    echo t('messages.welcome', ['name' => 'Frank']);
