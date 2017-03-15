# Commands

_Utility class to interact with user on the command line_

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> This manual is not finished yet!

- [Introduction](#introduction)
- [Running Commands](#running)
- [Writing Commands](#writing)
    - [Name and Description](#name)
    - [Arguments](#arguments)
    - [Options](#options)
    - [Handle](#handle)
    - [Help Screen](#help-screen)
- [Available Methods](#available-methods)
    
<a name="introduction"></a>
## Introduction

Pletfix includes a command line interface. It provides helpful commands for developing.

#### Source Hints for the Stdio Class 

`Stdio` is a wrapper for standard input/output streams. The command uses it under the hood for the input and output
methods to interact with the user. 

The code comes in part from the following sources:

- Aura for PHP, licensed under [BSD License](http://opensource.org/licenses/bsd-license.php):
    - The `Stdio` class based on [Aura.Cli's Stdio](https://github.com/auraphp/Aura.Cli/blob/2.x/src/Stdio.php) 
      and [Handle implementation](https://github.com/auraphp/Aura.Cli/blob/2.x/src/Stdio/Handle.php).  
- CakePHP, licensed under [MIT License](http://www.opensource.org/licenses/mit-license.php):
    - The `read()` method based on [CakePHP's ConsoleInput](https://github.com/cakephp/cakephp/blob/3.next/src/Console/ConsoleInput.php),
    - The VERBOSITY constants of the `Stdio` class and the methods `ask()`, `choice()`, `getInput()` and `hr()` are from 
      [CakePHP's ConsoleIo](https://github.com/cakephp/cakephp/blob/3.next/src/Console/ConsoleIo.php).
    - The `clear` function is copied from [CakePHP's Shell](https://github.com/cakephp/cakephp/blob/3.next/src/Console/Shell.php).
- Symfony, licensed under [MIT License](https://github.com/symfony/console/blob/master/LICENSE):
    - The verbosity functions are from [Symfony's Console Output Interface](https://github.com/symfony/console/blob/3.2/Output/OutputInterface.php).
    - The `hasColorSupport()` method is copied from [Symfony's StreamOutput](https://github.com/symfony/console/blob/3.2/Output/StreamOutput.php).
    - The signature of `table()` comes from [Symfony's SymfonyStyle](https://github.com/symfony/console/blob/3.2/Style/SymfonyStyle.php).
    - `secret()` and `hasSttyAvailable()` mehods based on [Symfony's QuestionHelper](https://github.com/symfony/console/blob/3.2/Helper/QuestionHelper.php).
- `format()` was inspired by [if not true then](https://www.if-not-true-then-false.com/2010/php-class-for-coloring-php-command-line-cli-scripts-output-php-output-colorizing-using-bash-shell-colors/).

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
 
The commands are stored in the `app/Commands` directory. The [Pletfix Application Skeleton](https://github.com/pletfix/app) 
has already placed a `SampleCommand` class as example in this directory. 

You may run this sample by enter following command in your terminal:
    
    php console sample:say-hello
    
<a name="name-and-description"></a>    
### Name and Description

The `$name`property of the command class is the unique indicator of the command. 

It could include a group, seperated with ":" from the name. The `help` option is therefore able to display the command 
list more clearly. For example, the group of this command is _"sample"_:
 
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sample:say-hello';
    
The `$description` property briefly describes what the command does. The `help` option displays the description when 
the commands are listed.
    
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

This example defines an argument named _"name"_ and the type of this argument is `string`. The following types are also 
possible:
- `bool`
- `float`
- `int` 
- `string`
 
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

This example defines an simple switch named _"bye"_ with the shortcut _"b"_. The type of this option is `bool`, 
a default value is not required and would be ignored.

As common usual, the options are indicated with two minus signs:

    php console sample:say-hello --bye
    
Most options provide a shortcut, which are start with just one minus sign. In our example, this looks like this:
    
    php console sample:say-hello -b

#### Options With Values

Furthermore, you may define options as `float`, `int` and `string` like this:

    protected $options = [
        'rating' => [
            'type'        => 'int', 
            'short'       => 'r',
            'default'     => 0,
            'description' => 'Your Rating between 1 and 10'
        ],
    ];

The user must specify a value for this option by running the command, such as:

    php console jury --rating=32

Of course, for `float`, `int` and `string` types, it is useful to define a default value, unless the default should be 
null.
    
    
<a name="handle"></a>
### Handle

The `handle` method is your entry point for coding. To understand what happens under the hood, study the 
[Lifecycle](lifecycle#console).

You may use the most services in the same way as in your web application because the console runs in a simillar context.
Additional, the Command class provides a [variety of methods](#available-methods) to interact with the user.

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->input('bye')) {
            $this->line('Good by, ' . $this->input('name') . '.');
        }
        else {
            $this->line('Hello ' . $this->input('name') . '.');
        }
    }

#### Exit Code

The return value of the `handle` method should be the exit code for the command. 

For conventional reasons you could returns also nothing or `true`. In this case the exit code of the command will 
be `static::EXIT_SUCCESS` (equal 0).

And if the return value is `false`, the exit code will be converted to `static::EXIT_FAILURE` (equal 1).
  

### Help Screen

It's poosible to extends the default help screen:

    /**
     * Print the Help
     */
    public function printHelp()
    {
        parent::printHelp();

        $this->notice('Importend Notice!');
        $this->line('Lorem ipsum dolor sit amet, consectetur, adipisci velit.');
    }
    
> Do not forget calling `parent::printHelp();`!     
    
        
<a name="available-methods"></a>
## Available Methods

### Input

<div class="method-list" markdown="1">

[ask](#method-ask)
[canRead](#method-can-read)
[choice](#method-choice)
[confirm](#method-confirm)
[read](#method-read)
[secret](#method-secret)

</div>

### Output

<div class="method-list" markdown="1">

[debug](#method-debug)
[error](#method-error)
[format](#method-format)
[hr](#method-hr)
[info](#method-info)
[line](#method-line)
[notice](#method-notice)
[question](#method-question)
[quiet](#method-quiet)
[table](#method-table)
[verbose](#method-verbose)
[warn](#method-warn)
[write](#method-write)

</div>

### Miscellaneous

<div class="method-list" markdown="1">

[arguments](#method-arguments)
[clear](#method-clear)
[description](#method-description)
[input](#method-input)
[isDebug](#method-is-debug)
[isQuiet](#method-is-quiet)
[isVerbose](#method-is-verbose)
[name](#method-name)
[options](#method-options)
[stdio](#method-stdio)
[terminalHeight](#method-terminal-height)
[terminalWidth](#method-terminal-width)

</div>

<a name="method-listing"></a>
## Method Listing

<a name="input"></a>
### Input

<a name="method-ask"></a>
#### `ask()` {.method .first-method}

Prompts the user for input, and returns it.

    public function ask($prompt, $default = null);

<a name="method-can-read"></a>
#### `canRead()` {.method}

Check if data is available on standard input.

    public function canRead($timeout = 0);

<a name="method-choice"></a>
#### `choice()` {.method}

    /**
     * Prompts the user for input based on a list of options, and returns it.
     *
     * @param string $prompt Prompt text.
     * @param array $options Array of options.
     * @param string|null $default Default input value.
     * @return mixed Either the default value, or the user-provided input.
     */
    public function choice($prompt, $options, $default = null);

<a name="method-confirm"></a>
#### `confirm()` {.method}

    /**
     * Asking for Confirmation
     *
     * If you need to ask the user for a simple confirmation, you may use the confirm method. By default, this method
     * will return false. However, if the user enters y or yes in response to the prompt, the method will return true.
     *
     * @param string $prompt Prompt text.
     * @param boolean $default Default input value, true or false.
     * @return mixed Either the default value, or the user-provided input.
     */
    public function confirm($prompt, $default = false);

<a name="method-read"></a>
#### `read()` {.method}

    /**
     * Prompts the user for input, and returns it.
     *
     * @param string $prompt Prompt text.
     * @param string|array|null $options String of options. Pass null to omit.
     * @param string|null $default Default input value. Pass null to omit.
     * @return string Either the default value, or the user-provided input.
     */
    public function read($prompt, $options = null, $default = null);

<a name="method-secret"></a>
#### `secret()` {.method}

    /**
     * Asks a question with the user input hidden.
     *
     * The secret method is similar to ask, but the user's input will not be visible to them as they type in the console.
     * This method is useful when asking for sensitive information such as a password.
     *
     * The function will run only on a unix like system (linux or mac).
     *
     * @param string $prompt Prompt text.
     * @param string|null $default Default input value.
     * @return mixed Either the default value, or the user-provided input.
     */
    public function secret($prompt, $default = null);


<a name="output"></a>
### Output

<a name="method-debug"></a>
#### `debug()` {.method .first-method}

    /**
     * Output at the debug level.
     *
     * @param string $text
     * @param array $styles Combination of Stdio::STYLE constants
     */
    public function debug($text, array $styles = []);

<a name="method-error"></a>
#### `error()` {.method}

    /**
     * Write an error text.
     *
     * @param string $text
     */
    public function error($text);

<a name="method-format"></a>
#### `format()` {.method}

    /**
     * Format text.
     *
     * @param string $text The message
     * @param array $styles Combination of Stdio::STYLE constants
     * @return string
     */
    public function format($text, array $styles = []);

<a name="method-hr"></a>
#### `hr()` {.method}

    /**
     * Outputs a series of minus characters to the standard output, acts as a visual separator.
     *
     * @param int $width Width of the line, defaults to 79
     */
    public function hr($width = 79);

<a name="method-info"></a>
#### `info()` {.method}

    /**
     * Write a information.
     *
     * @param string $text
     */
    public function info($text);

<a name="method-line"></a>
#### `line()` {.method}

    /**
     * Write standard text.
     *
     * @param string $text
     */
    public function line($text);

<a name="method-notice"></a>
#### `notice()` {.method}

    /**
     * Write a notice.
     *
     * @param string $text
     */
    public function notice($text);

<a name="method-question"></a>
#### `question()` {.method}

    /**
     * Write a question.
     *
     * @param string $text
     */
    public function question($text);

<a name="method-quiet"></a>
#### `quiet()` {.method}

    /**
     * Output at the quiet level.
     *
     * @param string $text
     * @param array $styles Combination of Stdio::STYLE constants
     */
    public function quiet($text, array $styles = []);

<a name="method-table"></a>
#### `table()` {.method}

    /**
     * Formats a table.
     *
     * Example:
     * +---------------+-----------------------+------------------+
     * | ISBN          | Title                 | Author           |
     * +---------------+-----------------------+------------------+
     * | 99921-58-10-7 | Divine Comedy         | Dante Alighieri  |
     * | 9971-5-0210-0 | A Tale of Two Cities  | Charles Dickens  |
     * | 960-425-059-0 | The Lord of the Rings | J. R. R. Tolkien |
     * +---------------+-----------------------+------------------+
     *
     * @param array $headers
     * @param array $rows
     */
    public function table(array $headers, array $rows);

<a name="method-verbose"></a>
#### `verbose()` {.method}

    /**
     * Output at the verbose level.
     *
     * @param string $text
     * @param array $styles Combination of Stdio::STYLE constants
     */
    public function verbose($text, array $styles = []);

Verbosity of Messages

Change verbosity of messages

    php console sample:say-hello --verbose=2

0=quiet, 1=normal, 2=verbose, 3=debug

<a name="method-warn"></a>
#### `warn()` {.method}

    /**
     * Write a warning.
     *
     * @param string $text
     */
    public function warn($text);
    
<a name="method-write"></a>
#### `write()` {.method}

    /**
     * Write a formatted text o standard output.
     *
     * @param string $text The message
     * @param bool $newline Whether to add a newline
     * @param array $styles Combination of Stdio::STYLE constants
     * @param int $verbosity Determine if the output should be only at the verbose level
     */
    public function write($text, $newline = false, array $styles = [], $verbosity = Stdio::VERBOSITY_NORMAL);


<a name="miscellaneous"></a>
### Miscellaneous

<a name="method-arguments"></a>
#### `arguments()` {.method .first-method}

    /**
     * Possible arguments of the command.
     *
     * This is an associative array where the key is the argument name and the value is the argument attributes.
     * Each attribute is a array with following values:
     * - type:        (string) The data type (bool, float, int or string).
     * - default:     (mixed)  The default value for the argument. If not set, the argument is required.
     * - description: (string) The description of the argument. Default: null
     *
     * @return array
     */
    public function arguments();

<a name="method-clear"></a>
#### `clear()` {.method}

    /**
     * Clear the console
     */
    public function clear();

<a name="method-description"></a>
#### `description()` {.method}

    /**
     * The console command description.
     *
     * @return string
     */
    public function description();

<a name="method-input"></a>
#### `input()` {.method}

    /**
     * Get the input value.
     *
     * @param string $key
     * @return array
     */
    public function input($key);
    
<a name="method-is-debug"></a>
#### `isDebug()` {.method}

    /**
     * Returns whether verbosity is debug (-vv).
     *
     * @return bool true if verbosity is set to VERBOSITY_DEBUG, false otherwise
     */
    public function isDebug();

<a name="method-is-quiet"></a>
#### `isQuiet()` {.method}

    /**
     * Returns whether verbosity is quiet (-q).
     *
     * @return bool true if verbosity is set to VERBOSITY_QUIET, false otherwise
     */
    public function isQuiet();

<a name="method-is-verbose"></a>
#### `isVerbose()` {.method}

    /**
     * Returns whether verbosity is verbose (-v) or debug (-vv).
     *
     * @return bool true if verbosity is set to VERBOSITY_VERBOSE or VERBOSITY_DEBUG, false otherwise
     */
    public function isVerbose();

<a name="method-name"></a>
#### `name()` {.method}

    /**
     * The console command name.
     *
     * @return string
     */
    public function name();

<a name="method-options"></a>
#### `options()` {.method}

    /**
     * Possible options of the command.
     *
     * This is an associative array where the key is the option name and the value is the option attributes.
     * Each attribute is a array with following values:
     * - type:        (string) The data type (bool, float, int or string).
     * - short:       (string) Alternative option name.
     * - default:     (mixed)  The default value for the option. If the default value is not set and the type is not bool, the option is required.
     * - description: (string) The description of the option. Default: null
     *
     * @return array
     */
    public function options();

<a name="method-stdio"></a>
#### `stdio()` {.method}

Returns a `Stdio` instance, a Standard Input/Output stream to interact with the user.

    $stdio = $this->stdio();
    
You can access the most of the methods of the `Stdio` class directly from the `AbstractCommand` so you normally do not 
need the roundabout way over stdio(). Exception are the following functions which are not served by the command class: 
     
    $stdio->err($text = null);    // Prints text to Standard Error.
    $stdio->getStdin();           // Returns the Standard Input handle.     
    $stdio->setStdin($stdin);     // Set a Standard Input handle    
    $stdio->getStdout();          // Returns the Standard Output handle.      
    $stdio->setStdout($stdout);   // Set a Standard Output handle       
    $stdio->getStderr();          // Returns the Standard Error handle.       
    $stdio->setStderr($stderr);   // Set a Standard Error handle.       
    $stdio->setVerbosity($level); // Sets the verbosity (one of the Stdio::VERBOSITY constants).       
    $stdio->getVerbosity();       // Gets the current verbosity (one of the Stdio::VERBOSITY constants).

#### Styles

The style constants of `Stdio` class based on the [ANSI/VT100 Terminal Control reference](http://www.termsys.demon.co.uk/vtansi.htm).

    const STYLE_BOLD       = 1;
    const STYLE_DIM        = 2;
    const STYLE_UL         = 4;
    const STYLE_BLINK      = 5;
    const STYLE_REVERSE    = 7;
    const STYLE_BLACK      = 30;
    const STYLE_RED        = 31;
    const STYLE_GREEN      = 32;
    const STYLE_YELLOW     = 33;
    const STYLE_BLUE       = 34;
    const STYLE_MAGENTA    = 35;
    const STYLE_CYAN       = 36;
    const STYLE_WHITE      = 37;
    const STYLE_BLACK_BG   = 40;
    const STYLE_RED_BG     = 41;
    const STYLE_GREEN_BG   = 42;
    const STYLE_YELLOW_BG  = 43;
    const STYLE_BLUE_BG    = 44;
    const STYLE_MAGENTA_BG = 45;
    const STYLE_CYAN_BG    = 46;
    const STYLE_WHITE_BG   = 47;

See also [PHP's manual](http://php.net/manual/en/features.commandline.io-streams.php).
           
<a name="method-terminal-height"></a>
#### `terminalHeight()` {.method}

    /**
     * Tries to figure out the terminal height in which this application runs.
     *
     * @return int|null
     */
    public function terminalHeight();

<a name="method-terminal-width"></a>
#### `terminalWidth()` {.method}

    /**
     * Tries to figure out the terminal width in which this application runs.
     *
     * @return int|null
     */
    public function terminalWidth();
    