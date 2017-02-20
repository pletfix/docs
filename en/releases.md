# Release Notes

_What are we working on?_

[Since 1.0.0]

## Feature List

Nachfolgend sind alle bisher geplanten und fertigegestellte Pletfix Versionen mit den angedachten Features aufgeführt.

|Feature  | Release | Status|
|:--------|:-------:|:-----:|
| Composer Package Manager, Autoloading | 0.0.1
| Testing (PHP Unit, Mink and Travic CI) | 0.0.1 | open 
| Global Functions |  0.0.1
| Dependency Injection | 0.0.2
| Environment Support | 0.0.2
| Configuration | 0.0.2
| HTTP Routing | 0.0.3
| Controller | 0.0.4
| HTTP Request Services | 0.0.5
| HTTP Response Services | 0.0.5
| Logging | 0.0.6
| Exception Handling | 0.0.7
| Pretty Error Reporting |  0.0.7
| Facades | 0.0.8 |Deprecated
| Caching | 0.0.9
| View Template Engine | 0.1.0
| Database Access Layer | 0.2.0
| Query Builder |  0.2.1
| Migrator | 0.2.2
| Seeder | 0.2.3 | open
| Collection | 0.2.4
| Console (Command line Interface) | 0.3.0 
| Plugin Management | 0.4.0
| Loading Bower-Packages via Composer | 0.4.1 
| Asset Management | 0.4.2
| Translator (l18n) | 0.4.2 | open
| Model | 0.4.3 | open
| Pletfix Application Skeleton | 0.5.0 | working
| Session Handling | 0.5.1 | open
| Cookies | 0.5.2 | open
| DateTime | 0.5.3 | open
| Str (Utility class for string operations) | 0.5.4 | open 
| Pluralizer | 0.5.4 | open 
| Middleware | 0.5.5 | open
| Crypt (Encryption and Decryption)  | 0.5.6 | open
| Mailer | 0.5.7 | open
| FormBuilder| 0.5.8 | open
| FormValidator| 0.5.8 | open
| CSRF Protection| 0.5.9 | open
| User Authenticate (with Login-Dialog) | 0.6.0 | open
| User Authorize (Roles and Permissions) | 0.6.0 | open
| User Registration Dialog | 0.6.1 | open
| Password Reset Function | 0.6.2 | open
| Password Remember Function | 0.6.3 | open
| Token Authentication with Rate Limiting | 0.6.4 | open
| Scheduled Tasks | 0.7.1 | open
| Image Manipulation | 0.7.2 | open
| Zipper | 0.7.3 | open
| Scaffolder | 0.7.4 | open
| Markdown Parser | 0.7.4 | open
| PDF Writer | 0.7.5 | open
| Pletfix Dokumentaton | 0.8.0 | working
| Benchmark Test (Profiler) | 0.9.0 | open
| SOUP Services | 0.9.1 | open
| REST Services (with CURL) | 0.9.2 | open
| WebSocket | 0.9.3 | open
| Process Handling (inkl. Daemons) | 0.9.4 | open
| Database Import, Export, Backup and Restore | 0.9.5 | open
| Optional paramters for HTTP Routing | 0.9.6 | open
| LUA Support (Inline Scripting) | &gt; 1.0.0 | open
| FTP Client | &gt; 1.0.0 | open
| OAuth2 | &gt; 1.0.0 | open
| Agent (User agent information) | &gt; 1.0.0 | open
| ExcelWriter | &gt; 1.0.0 | open
| ExcelReader | &gt; 1.0.0 | open
| Update-Manager | &gt; 1.0.0 | open

> Hinweis: Die geplanten Features bzw. die zugeordneten Versionen können und werden sich wahrscheinlich im Laufe der Entwicklung noch ändern. 

<!-- 
Testing
    PHPUnit
        http://florianherlings.de/artikel/php_integration_testing_phpunit_mink
    Mink
        http://mink.behat.org/en/latest/
    Travis CI
        https://travis-ci.org
        https://www.thewebhatesme.com/entwicklung/travis-ci/
-->

<!--
Session-Handling 
    https://github.com/auraphp/Aura.Session/blob/2.x/README.md

Cookies - Work with cookies
    https://fuelphp.com/docs/classes/cookie.html
    in Laravel ist es Teil vom Request-Objekt
    
Crypt - Encryption and Decryption
    https://laravel.com/docs/5.4/encryption
    https://fuelphp.com/docs/classes/crypt/usage.html   
     
DateTime (\Carbon\Carbon)
    - https://github.com/fightbulc/moment.php
    - http://momentjs.com/docs/
    oder:
    - https://github.com/cakephp/chronos
   
Image   
   Image manipulation using GD or ImageMagick (s. FuelPHP)
   
FTP Client 
    Send or receive files using FTP (s. FuelPHP)
     
Pluralizer
    https://github.com/propelorm/Propel2/tree/master/src/Propel/Common/Pluralizer
     
Str 
    Utility class for string operations (s. FuelPHP)
     
Agent 
    User agent information (s. https://fuelphp.com/docs/classes/agent/usage.html)
   
     
Database Access Layer:
    - Rückgabe von query() ändern-> collection() (lediet die Performance?)
    - database-Objekt, Wording ändern: "column type supported by Database Layer" -> "database abstract type"
    - getSql() für db-Objekt. Evtl zentral steuerbar machen, dass mitgeloggt werden kann.
    - Besser: Event-Handlich einbauene

Model (ORM, ActiveRecord, Repository)
    ActiveRecord oder DataMapper?
    Kandidaten:  http://www.gajotres.net/best-available-php-orm-libraries-part-1/
    - Eloquent
    - Doctrine2 (Using Doctrine 2 will be an overkill.)
        http://www.doctrine-project.org/
        https://www.sitepoint.com/laravel-doctrine-best-of-both-worlds/
        http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/data-retrieval-and-manipulation.html
    - Propel2
        http://propelorm.org/Propel/documentation/
        https://github.com/propelorm/Propel2     
-->



