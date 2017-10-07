# Lifecycle

[Since 0.5.0]

- [Lifecycle Web Request](#web)
- [Lifecycle Console Command](#console)
- [Lifecycle Testing](#testing)

<a name="web"></a>
## Lifecycle Web Request

### Entry Point

The entry point for all web requests to a Pletfix application is the `public/index.php` file. 
All requests are directed to this file by your web server (Apache / Nginx) configuration. 
The `index.php` is starts the autoloader first and your application second by calling `\Core\Application::run()` for 
loading the rest of the framework.
    
        /*
         * Save the start time for benchmark tests.
         */
        define('APP_STARTTIME', microtime(true));
        
        /*
         * Set the base path for the application.
         */
        define('BASE_PATH', realpath(__DIR__ . '/..'));
        
        /*
         * Register the Composer Autoloader
         *
         * @link https://getcomposer.org/
         */
        require __DIR__ . '/../vendor/autoload.php';
        
        /*
         * Run...
         */
        \Core\Application::run();

### Application

1. Load Services

    The `Application::run()` pushes services into the [Dependency Injector](di).
    The services are defined in `boot/services.php` and in enabled plugins.

        /*
         * Push the Services into the Dependency Injector.
         */
        call_user_func(function() {
            @include self::$basePath . '/.manifest/plugins/services.php';
            require self::$basePath . '/boot/services.php';
        });

2. Execute Bootstraps 

    After loading the services the bootstraps, which are defined in `boot/bootstrap.php` (and in enabled plugins), 
    will be executed:

        /*
         * Bootstrap the framework
         */
        call_user_func(function() {
            require self::$basePath . '/boot/bootstrap.php';
            @include self::$basePath . '/.manifest/plugins/bootstrap.php';
        });

3. Register Routes

    Next the routes will be loaded. They are defined in `boot/routes.php` and in enabled plugins.
       
        /*
         * Register routes.
         */
        call_user_func(function() {
            require self::$basePath . '/boot/routes.php';
            @include self::$basePath . '/.manifest/plugins/routes.php';
        });

4. Once the application has been bootstrapped and all service providers have been registered, the HTTP request will be 
   handed off to the HTTP Router for dispatching. The router will dispatch the request to a action handler or controller:

        /*
         * Dispatch the HTTP request and send the response to the browser.
         */
        $request = DI::getInstance()->get('request');
        $response = static::route()->dispatch($request);
        $response->send();

### Controller

The controller, which is called by the HTTP Router, will handle the request and generate a HTTP response:
    
    /**
     * Show the index page.
     *
     * @return string
     */
    public function index()
    {
        return view('home');
    }
    
<a name="console"></a>
## Lifecycle Console Command

### Executable Script

The executable script to start a Pletfix console command is the `console` file. 
  
The script starts the autoloader first and second the console by calling `\Core\Console::run()` for loading the 
rest of the framework.
    
    #!/usr/bin/env php
    <?php
    
    /*
     * Save the start time for benchmark tests.
     */
    define('APP_STARTTIME', microtime(true));
    
    /*
     * Set the base path for the application.
     */
    define('BASE_PATH', __DIR__);
    
    /*
     * Register the Composer Autoloader
     *
     * @link https://getcomposer.org/
     */
    require __DIR__ . '/vendor/autoload.php';
    
    /*
     * Run...
     */
    $status = \Core\Console::run();
    
    exit($status);

### Console

1. Load Services

    The `Console::run()` pushes the services into the [Dependency Injector](di). The services are defined in 
    `boot/services.php` and in enabled plugins.

        /*
         * Push the Services into the Dependency Injector.
         */
        call_user_func(function() {
            @include self::$basePath . '/.manifest/plugins/services.php';
            require self::$basePath . '/boot/services.php';
        });

2. Execute Bootstraps 

    After loading the services the bootstraps will be executed. THe bootsraps are defined in `boot/bootstrap.php` 
    and in enabled plugins:

        /*
         * Bootstrap the framework
         */
        call_user_func(function() {
            require self::$basePath . '/boot/bootstrap.php';
            @include self::$basePath . '/.manifest/plugins/bootstrap.php';
        });


3. Once the application has been bootstrapped and all service providers have been registered, the command arguments 
   will be handed to the Command Factory for running the command which ist defined in `app/Commands` or in enabled plugins. 

        /*
         * Get the command line parameters
         */
        $argv = $_SERVER['argv'];
        array_shift($argv); // strip the application name ("console")

        /*
         * Dispatch the command line request.
         */
        /** @var \Core\Services\Contracts\Command|false $command */
        $command = DI::getInstance()->get('command-factory')->command($argv);
        
        return $command->run();

### Command

The command, which is created by the Command Factory, will handle the request and generate a console output:
    
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
        
<a name="testing"></a>
## Lifecycle Testing

### Executable Script
    
The executable script to start a Pletfix test is the `vendor/bin/phpunit` file. 
  
The script reads `phpunit.xml` (or `phpunit.xml.dist`, if the file not exists) and executes a bootstrap to set the 
testing environment.
    
### Bootstrap
    
PHPUnit runs the bootstrap before tests are executed. The bootstrap is defined in `tests/bootstrap.php`.
It starts the autoloader, the services and bootstraps defined in your application and in the registered plugins:
     
    /*
     * Save the start time for benchmark tests.
     */
    define('APP_STARTTIME', microtime(true));
    
    /*
     * Set the base path of the application.
     */
    define('BASE_PATH', realpath(__DIR__ . '/..'));
    
    /*
     * Register the Composer Autoloader.
     */
    require __DIR__ . '/../vendor/autoload.php';
    
    /*
     * Load the test environment.
     */
    Core\Testing\Environment::load();

### Environment

1. Load Services

    `Environment::load()` pushes the services into the [Dependency Injector](di). The services are defined in 
    `boot/services.php` and in enabled plugins.

        /*
         * Push the Services into the Dependency Injector.
         */
        call_user_func(function() {
            @include self::$basePath . '/.manifest/plugins/services.php';
            require self::$basePath . '/boot/services.php';
        });

2. Execute Bootstraps 

    After loading the services the bootstraps will be executed. THe bootsraps are defined in `boot/bootstrap.php` 
    and in enabled plugins:

        /*
         * Bootstrap the framework
         */
        call_user_func(function() {
            require self::$basePath . '/boot/bootstrap.php';
            @include self::$basePath . '/.manifest/plugins/bootstrap.php';
        });
        
### Test Case
 
1. After executing the bootstrap the `setUp` method of `TestCase` (or `MinkTestCase`) is called by PHPUnit. Be default, 
   the method is empty:

        protected function setUp()
        {
        }
  
2. After setup the test cases are calling:
  
        public function testBasicExample()
        {
            $this->assertEquals(1, 1);
        }
  
3. At last the `tearDown` method is invoked:
  
        protected function tearDown()
        {
        }
