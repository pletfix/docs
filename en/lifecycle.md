# Lifecycle

[Since 0.5.0]

- [Lifecycle Web Request](#web)
- [Lifecycle Console Command](#console)
- [Lifecycle Testing](#testing)

<a name="lifecycle-web"></a>
## Lifecycle Web Request

### Entry Point

The entry point for all web requests to a Pletfix application is the `public/index.php` file. 
All requests are directed to this file by your web server (Apache / Nginx) configuration. 
The `index.php` is starting first the Autoloader and second the application by calling `\Core\Application::run()` for loading the rest of the framework.
    
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

    On the first time the `Application::run()` will do is to push the services, which defined in `config/boot/services.php` (and in enabled plugins), into the Dependency Injector:

        /*
         * Push the Services into the Dependency Injector.
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/services.php';
            @include __DIR__ . '/../../../../.manifest/plugins/services.php';
        });

2. Execute Bootstraps 

    After loading the services the bootstrap, which defined in `config/boot/bootstrap.php` (and in enabled plugins), will be executed:

        /*
         * Bootstrap the framework
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/bootstrap.php';
            @include __DIR__ . '/../../../../.manifest/plugins/bootstrap.php';
        });

3. Register Routes

    Next the Routes defined in `config/boot/routes.php` (and in enabled plugins) will be loaded:
       
        /*
         * Register routes.
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/routes.php';
            @include __DIR__ . '/../../../../.manifest/plugins/routes.php';
        });

4. Once the application has been bootstrapped and all service providers have been registered, the HTTP request will be handed off to the HTTP Router for dispatching. 
   The router will dispatch the request to a route or controller:

        /*
         * Dispatch the HTTP request and send the response to the browser.
         */
        $request = DI::getInstance()->get('request');
        $response = static::route()->dispatch($request);
        $response->send();

### Controller

The controller action, which called by the HTTP Router, will be handle the request and generated a HTTP response:
    
    /**
     * Show the index page.
     *
     * @return string
     */
    public function index()
    {
        return view('home');
    }
    
<a name="lifecycle-console"></a>
## Lifecycle Console Command

### Executable Script

The executable script to start a Pletfix console commands is the `console` file. 
  
The script is starting first the Autoloader and second the console by calling `\Core\Console::run()` for loading the rest of the framework.
    
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

    On the first time the `Console::run()` will do is to push the services, which defined in `config/boot/services.php` (and in enabled plugins), into the Dependency Injector:

        /*
         * Push the Services into the Dependency Injector.
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/services.php';
            @include __DIR__ . '/../../../../.manifest/plugins/services.php';
        });

2. Execute Bootstraps 

    After loading the services the bootstrap, which defined in `config/boot/bootstrap.php` (and in enabled plugins), will be executed:

        /*
         * Bootstrap the framework
         */
        call_user_func(function() {
            require __DIR__ . '/../../../../config/boot/bootstrap.php';
            @include __DIR__ . '/../../../../.manifest/plugins/bootstrap.php';
        });


3. Once the application has been bootstrapped and all service providers have been registered, the the command arguments 
   will be handed off to the Command Factory for running the command which ist defined in app/Commands (or in enabled plugins). 

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

The Command, which created by the Command Factory, will be handle the request and generated a console output:
    
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
        
<a name="lifecycle-testing"></a>
## Lifecycle Testing

### Executable Script
    
The executable script to start a Pletfix test is the `vendow/bin/phpunit` file. 
  
The script is reading `phpunit.xml` and execute a Bootstrap to set the testing environment.
    
### Bootstrap
    
PHPUnit run the Bootstrap before test are executed. 
The Bootstrap is defined in `vendor/pletfix/core/tests/bootstrap.php`.
The Bootstrap is principle only starting the Autoloader:
     
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
 
1. After execute the Bootstrap the `setUp` method of `TestCase` (or `MinkTestCase`) is called by PHPUnit to load the 
   Services defined in `config/boot/services.php` and the application's bootstraps defined in `config/boot/bootstrap.php`: 

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
  