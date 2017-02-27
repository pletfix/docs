# Dependency Injection

[Since 0.5.0]

TODO: Erklären, was DI ist und welche Vorteiel es hat.

http://auraphp.com/packages/3.x/Di/


## Lazy Injection

http://auraphp.com/packages/3.x/Di/lazy.html#1-1-6


### Services

http://auraphp.com/packages/3.x/Di/services.html#1-1-5

A "service" is an object stored in the Container under a unique name. Any time you get() the named service, you always get back the same object instance.
   

<!--
<a name="facades-vs-dependency-injection"></a>
### Facades Vs. Dependency Injection

One of the primary benefits of dependency injection is the ability to swap implementations of the injected class. 
This is useful during testing since you can inject a mock or stub and assert that various methods were called on the stub.

Typically, it would not be possible to mock or stub a truly static class method. However, since facades use dynamic methods to proxy method calls to objects resolved from the service container, we actually can test facades just as we would test an injected class instance. For example, given the following route:

    use Illuminate\Support\Facades\Cache;

    Route::get('/cache', function () {
        return Cache::get('key');
    });

We can write the following test to verify that the `Cache::get` method was called with the argument we expected:

    use Illuminate\Support\Facades\Cache;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        Cache::shouldReceive('get')
             ->with('key')
             ->andReturn('value');

        $this->visit('/cache')
             ->see('value');
    } 
-->    