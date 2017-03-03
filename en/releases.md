# Release Notes

_What are we working on?_

[Since 0.5.0]

## Feature List

Nachfolgend sind alle bisher geplanten und fertigegestellte Pletfix Versionen mit den angedachten Features aufgeführt.    

| Feature  | Release | Status |
|:---------|:-------:|:------:|
| Composer Package Manager, Autoloading | 0.0.1 | Release Candidate |
| Global Functions |  0.0.1 | Alpha |
| Dependency Injection | 0.0.2 | Alpha | 
| Environment Support | 0.0.2 | Alpha |
| Configuration | 0.0.2 | Alpha |
| Testing (PHP Unit, Mink and Travic CI) | 0.0.3 | |
| HTTP Routing | 0.0.4 | Alpha |
| Controller | 0.0.4 | Alpha |
| HTTP Request Services | 0.0.5 | Alpha |
| HTTP Response Services | 0.0.5 | Alpha |
| Logging | 0.0.6 | Alpha |
| Exception Handling | 0.0.7 | Alpha |
| Pretty Error Reporting |  0.0.7 | Alpha |
| Facades | 0.0.8 | Deprecated |
| Caching | 0.0.9 | Alpha |
| View Template Engine | 0.1.0 | Alpha |
| Database Access Layer | 0.2.0 | Alpha |
| Query Builder |  0.2.1 | Alpha |
| Migrator | 0.2.2 | Alpha |
| Seeder | 0.2.3 | |
| Collection | 0.2.4 | Alpha |
| Console (Command line Interface) | 0.3.0 | Alpha | 
| Plugin Management | 0.4.0 | Alpha |
| Loading Bower-Packages via Composer | 0.4.1 | Alpha | 
| Asset Management | 0.4.2 | Alpha |
| Markdown Parser | 0.4.3 | Alpha |
| Pletfix Application Skeleton | 0.5.0 | Working |
| Pletfix Documentation | 0.5.0 | Working |
| Session Handling | 0.5.1 | |
| Translator (l18n) | 0.5.2 | |
| Cookies | 0.5.3 | |
| DateTime | 0.5.4 | |
| Str (Utility class for string operations) | 0.5.5 | | 
| Pluralizer | 0.5.6 | |
| Mailer | 0.5.7 | |
| Model | 0.6.0 | |
| Old Input | 0.6.1 | |
| Flash Messages | 0.6.2 | |
| FormBuilder| 0.6.3 | |
| CSRF Protection | 0.6.4 | |
| File Upload | 0.6.5 | |
| File Download | 0.6.5 | |
| Ajax Request | 0.6.6 | |
| FormValidator| 0.6.7 | |
| Redirect for HTTP Response | 0.6.8 | |
| Middleware | 0.7.0 | |
| Crypt (Encryption and Decryption) | 0.7.1 | |
| User Authenticate (with Login-Dialog) | 0.7.2 | |
| User Authorize (Roles and Permissions) | 0.7.3 | |
| User Registration Dialog | 0.7.4 | |
| Password Reset Function | 0.7.5 | |
| Password Remember Function | 0.7.6 | |
| Token Authentication with Rate Limiting | 0.8.0 | |
| Scheduled Tasks | 0.8.1 | |
| Image Manipulation | 0.8.2 | |
| Zipper | 0.8.3 | |
| Scaffolder | 0.8.4 | |
| PDF Writer | 0.8.5 | |
| Benchmark Test (Profiler) | 0.9.0 | |
| SOUP Services | 0.9.1 | |
| REST Services (with CURL) | 0.9.2 | |
| WebSocket | 0.9.3 | |
| Process Handling (inkl. Daemons) | 0.9.4 | |
| Database Import, Export, Backup and Restore | 0.9.5 | |
| Optional paramters for HTTP Routing | 0.9.6 | |
| PSR-7 for HTTP Request/Response | 0.9.7 | |
| Notification Events | 0.9.8 | |
| **First Stable Release** | **1.0.0** | |
| LUA Support (Inline Scripting) | &gt; 1.0.0 | |
| FTP Client | &gt; 1.0.0 | |
| OAuth2 | &gt; 1.0.0 | |
| Agent (User agent information) | &gt; 1.0.0 | |
| ExcelWriter | &gt; 1.0.0 | |
| ExcelReader | &gt; 1.0.0 | |
| Update-Manager | &gt; 1.0.0 | |
| Extending Blade Feature | &gt; 1.0.0 | |

> 
<i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i> Die geplanten Features bzw. die zugeordneten Versionen können und werden sich wahrscheinlich im Laufe der Entwicklung noch ändern. 

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

PSR-7: HTTP message interfaces (für HTTP Request/Response)
    http://www.php-fig.org/psr/psr-7/
-->



