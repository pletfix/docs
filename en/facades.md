# Facades

[Since 1.0.0]

TODO: Erklären, was Facades sind und welche Vorteile es hat die Nachteile diskutieren

[Facades by Laravel](https://laravel.com/docs/5.4/facades)

###Facades Vs. Dependency Injection

One of the primary benefits of dependency injection is the ability to swap implementations of the injected class. This is useful during testing since you can inject a mock or stub and assert that various methods were called on the stub.

Typically, it would not be possible to mock or stub a truly static class method. However, since facades use dynamic methods to proxy method calls to objects resolved from the service container, we actually can test facades just as we would test an injected class instance. For example, given the following route:

