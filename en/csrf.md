# CSRF Protection

[Since 0.5.0]

- [Introduction](#introduction)
- [Form](#form)
- [Middleware](#middleware)
- [Ajax](#ajax)
- [Exception List](#except)

<a name="introduction"></a>
## Introduction

Read this [article from Wikipedia](https://en.wikipedia.org/wiki/Cross-site_request_forgery) to learn what a 
Cross-site request forgery is.

To protect your application for CSRF attacks, consider the following.

<a name="form"></a>
### Form

You should add a hidden field with a CSRF token in each form like this:

    <input name="_token" value="{{csrf_token()}}" type="hidden"/>

<a name="middleware"></a>
### Middleware

Pletfix provides a middleware out of the box to check the CSRF token. You may add this middleware into your route 
file like this:

    $route->middleware('csrf');

If you have bind the CSRF middleware like above, a POST request are only accepted if it has a valid CSRF token.  

<a name="ajax"></a>
### Ajax

The `csrf` middleware read the token also from the header "X-CSRF-TOKEN". Therefore, if you use the jQuery library, you 
could set the CSRF token globally like this to send the token by every request automatically:

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
If you have installed the [Pletfix Application Skeleton](https://github.com/pletfix/app), this setup above is already
done.

<a name="except"></a>
### Exception List      

TODO      