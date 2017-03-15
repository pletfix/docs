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
    The services are defined in `config/boot/services.php` and in enabled plugins.

        /*
         * Push the Services into the Dependency Injector.
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/services.php';
            @include __DIR__ . '/../../../../.manifest/plugins/services.php';
        });

2. Execute Bootstraps 

    After loading the services the bootstraps, which are defined in `config/boot/bootstrap.php` (and in enabled plugins), 
    will be executed:

        /*
         * Bootstrap the framework
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/bootstrap.php';
            @include __DIR__ . '/../../../../.manifest/plugins/bootstrap.php';
        });

3. Register Routes

    Next the routes will be loaded. They are defined in `config/boot/routes.php` and in enabled plugins.
       
        /*
         * Register routes.
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/routes.php';
            @include __DIR__ . '/../../../../.manifest/plugins/routes.php';
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
    `config/boot/services.php` and in enabled plugins.

        /*
         * Push the Services into the Dependency Injector.
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/services.php';
            @include __DIR__ . '/../../../../.manifest/plugins/services.php';
        });

2. Execute Bootstraps 

    After loading the services the bootstraps will be executed. THe bootsraps are defined in `config/boot/bootstrap.php` 
    and in enabled plugins:

        /*
         * Bootstrap the framework
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/bootstrap.php';
            @include __DIR__ . '/../../../../.manifest/plugins/bootstrap.php';
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
    
The executable script to start a Pletfix test is the `vendow/bin/phpunit` file. 
  
The script is reading `phpunit.xml` and execute a bootstrap to set the testing environment.
    
### Bootstrap
    
PHPUnit runs the bootstrap before tests are executed. The bootstrap is defined in `vendor/pletfix/core/tests/bootstrap.php`.
It starts in principle just the autoloader:
     
    /*
     * Save the start time for benchmark tests.
     */
    define('APP_STARTTIME', microtime(true));
    
    /*
     * Set the base path for the application.
     */
    define('BASE_PATH', realpath(__DIR__ . '/../../../..'));
    
    /*
     * Register the Composer Autoloader
     *
     * @link https://getcomposer.org/
     */
    require __DIR__ . '/../../../../vendor/autoload.php';    
 
### Test Case
 
1. After executing the bootstrap the `setUp` method of `TestCase` (or `MinkTestCase`) is called by PHPUnit to load the 
   services defined in `config/boot/services.php` and your application bootstraps defined in `config/boot/bootstrap.php`: 

        protected function setUp()
        {
            /*
             * Push the Services into the Dependency Injector.
             */
            call_user_func(function() {
                require __DIR__ . '/../../../../../config/boot/services.php';
                @include __DIR__ . '/../../../../../.manifest/plugins/services.php';
            });
    
            /*
             * Bootstrap the framework
             */
            call_user_func(function() {
                require __DIR__ . '/../../../../../config/boot/bootstrap.php';
                @include __DIR__ . '/../../../../../.manifest/plugins/bootstrap.php';
            });
        }
  
2. After setup the test cases are calling:
  
        public function testBasicExample()
        {
            $this->assertEquals(1, 1);
        }
  