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
 
To configure the Pletfix Logger, you may modify the options in your `config/logger.php` configuration file.

<a name="usage"></a>
## Usage the Logger

Pletfix create the log files in the `storage/logs` directory.

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