# Contribution Guide

_Make sure you read this before sending a pull request._

[Since 1.0.0]

TODO: Erweitern (Core Developing, Plugin Developing)

- [Which Branch?](#which-branch)
- [Coding Style](#coding-style)
    - [PHPDoc](#phpdoc)

<a name="which-branch"></a>
## Which Branch?

**All** bug fixes should be sent to the latest stable branch. Bug fixes should **never** be sent to the `master` branch unless they fix features that exist only in the upcoming release.

**Minor** features that are **fully backwards compatible** with the current Laravel release may be sent to the latest stable branch.

**Major** new features should always be sent to the `master` branch, which contains the upcoming Laravel release.

If you are unsure if your feature qualifies as a major or minor, please ask Taylor Otwell in the `#internals` channel of the [LaraChat](https://larachat.co) Slack team.

<a name="coding-style"></a>
## Coding Style

Laravel follows the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard and the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard.

<a name="phpdoc"></a>
### PHPDoc

Below is an example of a valid Laravel documentation block. Note that the `@param` attribute is followed by two spaces, the argument type, two more spaces, and finally the variable name:

    /**
     * Register a binding with the container.
     *
     * @param  string|array  $abstract
     * @param  \Closure|string|null  $concrete
     * @param  bool  $shared
     * @return void
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        //
    }


<!--
FuelPHP

https://fuelphp.com

We need more awesome!
FuelPHP is a community driven framework. We welcome your input, comment, code contributions or bug fixes!
Help us make Fuel even better!
    Help out
    Repositories on Github
    Making pull-requests
    Reporting bugs
    Making feature requests
    
Namespacing    
Use namespaces in your applications classes    
-->