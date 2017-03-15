# Command Line Interface

_Utility class to interact with user on the commandline_

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> This manual is not finished yet!

- [Introduction](#introduction)
- [Running Commands](#running)
- [Writing Commands](#writing)
    - [Name and Description](#name)
    - [Arguments](#arguments)
    - [Options](#options)
    - [Handle](#handle)
- [Available Methods](#available-methods)
    

<a name="introduction"></a>
## Introduction

Pletfix includes a command line interface. It provides helpful commands for developing.

<a name="running"></a>
## Running Commands

Enter this into your terminal to view a list of all available commands:

    php console
    
Then add the command that you want to run, e.g. `migrate`:

    php console migrate

Every command includes a help screen. For example, enter this to view available arguments and options for the 
`migrate` command:

    php console migrate --help

![Pletfix Console](https://raw.githubusercontent.com/pletfix/docs/master/images/console.png)    
    
    
<a name="writing"></a>
## Writing Commands
 
The commands are stored in the `app/Commands` directory. 

As example, the [Pletfix Application Skeleton](https://github.com/pletfix/app) have already registered a `SampleCommand`. 

You may run this sample by enter following command in a terminal:
    
    php console sample:say-hello
    
<a name="name-and-description"></a>    
### Name and Description

The `$name`property is the unique indicator of the command. 

It could include a group, seperated with ":" from the name. The `help` option is therefore able to display the commands 
more clearly. For example, the group here is "sample":
 
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sample:say-hello';
    
The `$description` property briefly describes what the command does. The `help` option displays this when the commands 
are listed.
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just a simple example.';

<a name="arguments"></a>    
### Arguments

The `$arguments` property lists all possible arguments of the command like below:

    /**
     * Possible arguments of the command.
     *
     * @var array
     */
    protected $arguments = [
        'name' => [
            'type'        => 'string', 
            'default'     => 'Nobody', 
            'description' => 'Name'
        ],
    ];

This example defines an argument named "name" and the type of this argument is "string". The following types are also 
possible:
- 'bool'
- 'float'
- 'int' 
- 'string'
 
The argument in the example above is optional because a default value has been set. 
If the `default` key would be omitted, the argument would be required.

Test the argument, e.g. like this:

    php console sample:say-hello "Tiger Tom"


<a name="options"></a>    
### Options

#### Switches 

The `$options` property holds all possible options of the command like below:

    /**
     * Possible options of the command.
     *
     * @var array
     */
    protected $options = [
        'bye' => [
            'type'        => 'bool', 
            'short'       => 'b', 
            'description' => 'Say Good By'
        ],
    ];

This example defines an simple switch named "bye" with the shortcut "b". The type of this option is `bool`, therefore
a default value is not required and would be ignored.

The options are indicated with two minus signs:

    php console sample:say-hello --bye
    
Most options provide a shortcut, which are start with just one minus sign. In our example, this looks like this:
    
    php console sample:say-hello -b


#### Options With Values

Furthermore, you may define options as 'float', 'int' and 'string' like this:

    protected $options = [
        'rating' => [
            'type'        => 'int', 
            'short'       => 'r',
            'default'     => 0,
            'description' => 'Your Rating between 1 and 10'
        ],
    ];

The user must specify a value for this option, such as:

    php console jury --rating=32

Of course, for 'float', 'int' and 'string' types, it is useful to define a default value, unless the default 
should be null.
    
    
<a name="handle"></a>
### Handle

    /*
     * Exit Codes
     *
     * @see http://www.unix.com/man-page/freebsd/3/sysexits/
     */
    $exitCode = $this->handle();

    if ($exitCode === null || $exitCode === true) {
        $exitCode = static::EXIT_SUCCESS;
    }
    else  if ($exitCode === false) {
        $exitCode = static::EXIT_FAILURE;
    }
        
<a name="available-methods"></a>
## Available Methods

<div class="method-list" markdown="1">

[all](#method-all)
[avg](#method-avg)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-all"></a>
#### `all()` {.method .first-method}

blub

<a name="method-avg"></a>
#### `avg()` {.method}

bla


### Verbosity of Messages

Change verbosity of messages

    php console sample:say-hello --verbose=2

0=quiet, 1=normal, 2=verbose, 3=debug

    
    