# CSRF Protection

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.6.4

- [Introduction](#introduction)

<a name="introduction"></a>
## Introduction

TODO

<a name="method-csrf-field"></a>
#### `csrf_field()` {.method}

The `csrf_field` function generates an HTML `hidden` input field containing the value of the CSRF token. 
For example, using [Blade syntax](blade):

    {{ csrf_field() }}

<a name="method-csrf-token"></a>
#### `csrf_token()` {.method}

The `csrf_token` function retrieves the value of the current CSRF token:

    $token = csrf_token();
