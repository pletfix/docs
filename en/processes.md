# Processes

- [Introduction](#introduction)
- [Create a Process](#instance)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

Pletfix `Process` class starts a backround process using PHP's [proc_open] (http://php.net/manual/en/function.proc-open.php).

<a name="instance"></a>
## Create a Process Instance

You may use the `process()` function to create a process:

    $process = process('ls - l');
    
You could set environment variables, e.g. like this:
    
    $env = config('app.debug') ? ['XDEBUG_CONFIG' => 'idekey=PHPSTORM'] : null;

    $process = process($cmd, $env);   

Of course, you can redirect the output in the conventional way, e.g. into a file:

    $process = process($cmd . ' > output.txt 2>&1');

Or to Nirvana:

    $process = process($cmd . ' > /dev/null 2>&1');

If you still want the process to run in the background after the HTTP request is completed, add a `&`:

    $process = process($cmd . ' > /dev/null 2>&1 &');
    
<a name="available-methods"></a>
## Available Methods

<div class="method-list" markdown="1">

[run](#method-run)
[start](#method-start)
[wait](#method-wait)
[terminate](#method-terminate)
[kill](#method-kill)
[read](#method-read)
[write](#method-write)
[getOutput](#method-getOutput)
[getErrorOutput](#method-getErrorOutput)
[isRunning](#method-isRunning)
[getExitCode](#method-getExitCode)
[isSuccessful](#method-isSuccessful)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-run"></a>
#### `run()` {.method .first-method}

The `run` method runs a process:

    $exitcode = $process->run();
    
You may set a timeout in seconds to wait until the process is finished:    
    
    $exitcode = $process->run(60);
    
Note, that the command sequence below are the same as `$process->run()`:
    
    $process->start();
    $exitcode = $process->wait();
    
<a name="method-start"></a>
#### `start()` {.method}

The `start` method starts a background process:

    $process->start();

<a name="method-wait"></a>
#### `wait()` {.method}

The `wait` method waits for the process to terminate:

    $exitcode = $process->wait();
    
You may set a timeout in seconds or null to disable:
  
    $exitcode = $process->wait(60);

<a name="method-terminate"></a>
#### `terminate()` {.method}

The `terminate` method terminates the process:

    $process->terminate();
    
This optional parameter is only useful on POSIX operating systems; you may specify a signal to send to the
process using the kill(2) system call. The default is SIGTERM (15).

SIGTERM (15) is the termination signal. The default behavior is to terminate the process, but it also can be
caught or ignored. The intention is to kill the process, but to first allow it a chance to cleanup.

SIGKILL (9) is the kill signal. The only behavior is to kill the process, immediately. As the process cannot
catch the signal, it cannot cleanup, and thus this is a signal of last resort.

    $process->terminate(SIGKILL);
  
<a name="method-kill"></a>
#### `kill()` {.method}

The `kill` method kills the process immediately. It's a short way to invoke `$process->terminate(SIGKILL)`:

    $process->kill();
    
<a name="method-read"></a>
#### `read()` {.method}

The `read` method reads a line from STDOUT:

    $line = $process->read();

<a name="method-write"></a>
#### `write()` {.method}

The `write` method writes a line to STDIN:

    $process->write($string);
    
<a name="method-getOutput"></a>
#### `getOutput()` {.method}

The `getOutput` method gets the output from STDOUT when the process is finished:

    $output = $process->getOutput();
        
<a name="method-getErrorOutput"></a>
#### `getErrorOutput()` {.method}

The `getErrorOutput` method gets the error output from STDERR when the process is finished:

    $error = $process->getErrorOutput();    
    
<a name="method-isRunning"></a>
#### `isRunning()` {.method}

The `isRunning` method determines if the process is currently running:

    $process->isRunning();
        
<a name="method-getExitCode"></a>
#### `getExitCode()` {.method}

The `getExitCode` method gets the exit code returned by the process:

    $exitcode = $process->getExitCode();

<a name="method-isSuccessful"></a>
#### `isSuccessful()` {.method}

The `isSuccessful` method determines if the process ended successfully:

    $ok = $process->isSuccessful();

        