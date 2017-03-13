# Errors & Exceptions

_Handling errors in your application_

[Since 0.5.0]

- [Introduction](#introduction)
- [Exception Handler](#handler)
    - [Logging](#logging)
    - [Error Pages](#pages)
- [Exceptions](#exceptions)

<a name="introduction"></a>
## Introduction

If an exception is occur an exception handler will be triggered by the Pletfix application.

You may customize the handler and the error messages as you wish.

<a name="handler"></a>
## Exception Handler

The Pletfix Application Skeleton provides an exception handler that stored in `app/Handler/ExceptionHandler.php`.

If you wish you can define an another exception-handler. For do this open the `config/boot/services.php` file. 
In this file is the handler bound to the [Dependency Injection Container](di).

    $di->set('exception-handler', \App\Handler\ExceptionHandler::class, true);

You can change the class as you like.

The exception handler must extends `Core\Handler\Contracts\ExceptionHandler`. There is only the handler's invoke method 
`handle()` defined. The default handler of the Pletfix Application looks like this:

    public function handle(Exception $e)
    {
        try {
            $this->log($e);
        }
        catch (Exception $e) {
        }

        if (is_console()) {
            $this->handleForConsole($e);
        }
        else {
            $this->handleForBrowser($e);
        }
    }

First the default handler write a report to the log file. After then the exception message will print out. 

<a name="custom-logging"></a>
### Logging

The handler uses the [Pletfix Logger](logging) to write the log files. To configure the Logger, you should modify the 
`log` option in your `config/app.php` configuration file. Read the [manual](logging) for details.

<a name="pages"></a>
### Error Pages

The views of the error pages are stored in the `resources/views/errors` directory by default.

If the debug mode is disabled, the simple error page is shown depending on the HTTP status code. You may customize this 
error pages for various HTTP status codes. For example, if you wish to customize the error page for 501 HTTP status codes, 
create a `501.blade.php`. If the appropriate view is not exists, `default.blade.php` is rendered.

#### Debug Mode

You can set the debug mode in the configuration file `config/app.php`:
    
    'debug' => env('APP_DEBUG', false),

When your application is in debug mode, detailed error messages with stack traces (and SQL dump unless it is an SQL error) 
will be shown on every error that occurs. In this case `resources/views/errors/debug.blade.php` is rendered: 

![Pretty Error Page](https://raw.githubusercontent.com/pletfix/docs/master/images/error_page.png)


<a name="exceptions"></a>
## Exceptions

Pletfix provides a few exception classes stored in `vendor/pletfix/core/src/Exceptions`. A good place for your own 
exceptions classes is `app/Exceptions`.