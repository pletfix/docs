# Logging

_PSR-3 Logger Interface_

[Since 0.5.0]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Usage the Logger](#usage)

<a name="introduction"></a>
## Introduction

The Pletfix Logger is a PSR-3 compatible Adapter of the powerful [Monolog Logger](https://github.com/Seldaek/monolog).

See also [PSR-3 Specification](http://www.php-fig.org/psr/psr-3). 
 
<a name="configuration"></a>
## Configuration

Pletfix create the log files in the `storage/logs` directory. 
To configure the Pletfix Logger, you should modify the `log` option in your `config/app.php` configuration file: 

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings:
    | type:         Can be set to "single", "daily", "syslog" or "errorlog"
    | level:        The minimum PSR-3 logging level at which this handler will be triggered.
    |               Can be set to "debug", "info", "notice", "warning", "error", "critical", "alert" or "emergency"
    | max_files:    Only for daily log: Maximum files to use in the daily logging format (0 means unlimited).
    | permission:   Optional file permissions (null == 0644 are only for owner read/write)
    |
    */

    'log' => [
        'type'       => env('LOG_TYPE',  'daily'),
        'level'      => env('LOG_LEVEL', 'debug'),
        'max_files'  => 5,
        'app_file'   => 'app.log',
        'cli_file'   => 'cli.log',
        'permission' => 0664,
    ],

<a name="usage"></a>
## Usage the Logger

You may write information to the logs using the global helper function `logger()`:

    logger()->info('Showing user profile for user: ' . $id);
    
The logger provides the eight logging levels defined in [RFC 5424](https://tools.ietf.org/html/rfc5424):

    logger()->emergency($message);
    logger()->alert($message);
    logger()->critical($message);
    logger()->error($message);
    logger()->warning($message);
    logger()->notice($message);
    logger()->info($message);
    logger()->debug($message);

You can also call the member function `log()` that expected the logging level ("emergency", "alert", "critical", "error", "warning", "notice", "info" and "debug") as argument:

    logger()->log('debug', $message);
    
An array of contextual data may also be passed to the log methods. 
This contextual data will be formatted and displayed with the log message:

    logger()->info('User failed to login.', ['id' => $user->id]);
        
The message may contain placeholders in the form `{foo}` that will be replaced by the context data in key `'foo'`:

    logger()->info('User {id} failed to login.', ['id' => $user->id]);

The context array can contain arbitrary data, the only assumption that can be made by implementors is that if an
Exception instance is given to produce a stack trace, it must be in a key named `'exception'`.

    try {
        // ...
    }
    catch (Exception $e) {
        logger()->info('Operation failed!', ['exception' => $e]);
    }