<?php

/**
 * Table of Contents
 */

// Revision Mark einführen:
// [Revision 0.6.3]

return [
    
    'Getting Started' => [
        'index' => 'Overview, Licenses',
        'installation' => 'Installation',
        'upgrade' => 'Upgrade Guide',
        'hello' => 'Hello World Tutorial',
    ],
    'General' => [ // General Topics
        'cache' => 'Cache',
        'collections' => 'Collections',             // (*) kennzeichnen, welche Funktionen mutable sind
        'configuration' => 'Configuration',
        'commands' => 'Commands',                   // (*) !!!! This manual is not finished yet !!!!!
        'controllers' => 'Controllers',             // (*)
        'datetime' => 'DateTime',                   // (*)
        'di' => 'Dependency Injection',             // (*)
        'errors' => 'Errors &amp; Exceptions',      // (*)
        'flash' => 'Flash',                         // (*)
        'httpclient' => 'HTTP Client',              // (*) Ausformulieren!
        'helpers' => 'Helpers &amp; Services',      // (*) Misc und Services zusammen auflisten
        'plugins' => 'Plugins',                     // Beschreibung aus Hello-plugin/readme übernehmen
        'processes' => 'Processes',                 // (*)
        'requests' => 'HTTP Requests',              // (*), "various ways to get the url" in der Einführung
        'responses' => 'HTTP Responses',            // (*)
        'routing' => 'HTTP Routing',                // (*)
        'logging' => 'Logging',                     // (*)
        'mailer' => 'Mailer',
        'sessions' => 'Sessions',                   // (*)
        'testing' => 'Testing',
    ],
    'Frontend' => [
        'views' => 'Views',                         // (*)
        'blade' => 'Blade Templates',               // (*)
        'assets' => 'Assets',
        'localization' => 'Localization',           // (*)
        'forms' => 'Forms',                         // (*), Validation
        'pagination' => 'Pagination',               // (*)
        'cookies' => 'Cookies',                     // (*)
    ],
    'Database' => [
        'database' => 'Database Access Layer',      // (*), Misc und Scheam ausformulieren
        'builder' => 'Query Builder',               // (*)
        'models' => 'Models',                       // (*), Validation
        'migrations' => 'Migrations',
    ],
    'Security' => [
        'authentication' => 'Authentication',       // (*)
        'login' => 'Basic Web Login',               // (*)
        'ldap' => 'LDAP',                           // (*)
        'oauth' => 'OAuth',                         // (*)
        'middleware' => 'Middleware',               // (*)
        'csrf' => 'CSRF Protection',                // (*)
    ],
    'Appendix' => [
        'releases' => 'Release Notes',
        'directories' => 'Directory Structure',
        'contributions' => 'Contribution Guide',
        'lifecycle' => 'Lifecycle',
        'facades' => 'Facades',
    ],

    // (*) todo Korrektur lesen

    /*
      Not implemented yet:
        'scaffolder' => 'Scaffolder',
        'rest' => 'REST Service',
        'soap' => 'SOAP Service',
        'websocket' => 'WebSockets',
        'scheduler' => 'Scheduler',
        'events' => 'Notification Events',
    */

    // gehört in den Blog:
    //   'git' => 'Git Guide',

];