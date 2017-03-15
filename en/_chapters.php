<?php

/**
 * Table of Contents
 */

// todo
// Alle Inhaltsverzeichnisse angleichen

// Revision Mark einführen:
// [Revision 0.6.3]

return [

    'Getting Started' => [
        'index' => 'Overview',                      // bereits Korrektur gelesen todo: Allgemeine Beschreibung, wie die Anwendung funktioniert, MVC, DI, usw..., alle Third Party auflisten
        'installation' => 'Installation',           // bereits Korrektur gelesen
        'upgrade' => 'Upgrade Guide',               // bereits Korrektur gelesen
        'lifecycle' => 'Lifecycle',                 // bereits Korrektur gelesen todo: Auf Request- und Repsonse-Objekt eingehen
        'hello' => 'Hello World',                   // bereits Korrektur gelesen todo "Create a Table", "Add a Model" beschreiben
        'testing' => 'Testing',                     // bereits Korrektur gelesen
    ],
    'General' => [ // General Topics
        'cache' => 'Cache',                         // todo Kapitel ändern: "Introduction" ("Configuration", "Creating Cache"), "Available Methods"
        'collections' => 'Collections',             // todo kennzeichnen, welche Funktionen mutable sind
        'configuration' => 'Configuration',
        'commands' => 'Commands',                   // todo Ausformulieren, Querverweise setzen
        'controllers' => 'Controllers',
        'datetime' => 'DateTime',
        'di' => 'Dependency Injection',
        'errors' => 'Errors &amp; Exceptions',
        'helpers' => 'Helpers &amp; Services',
        'requests' => 'HTTP Requests',              // todo "various ways to get the url" in der Einführung
        'responses' => 'HTTP Responses',
        'routing' => 'HTTP Routing',
        'logging' => 'Logging',
        'mailer' => 'Mailer',
        'events' => 'Notification Events',
        'sessions' => 'Sessions',
    ],
    'Frontend' => [                                 // evtl "Tables" inkl. pagination hinzufügen
        'views' => 'Views',
        'blade' => 'Blade Templates',
        'assets' => 'Asset Manager',                // bereits Korrektur gelesen
        'localization' => 'Localization',
        'forms' => 'Forms',                         // todo Validation
    ],
    'Database' => [
        'database' => 'Database Access Layer',      // todo Misc und Scheam ausformulieren
        'models' => 'Models',                       // todo Validation
        'queries' => 'Query Builder',
        'pagination' => 'Pagination',               // evtl zu Frontend hinzufügen
        'migrations' => 'Migrations',
    ],
    'Security' => [
        'authentication' => 'Authentication',
        'oauth2' => 'OAuth2', // Global Token Authentication
        'middleware' => 'Middleware',
        'csrf' => 'CSRF Protection',
    ],
    'Plugin Management' => [                        // evtl beides zusammenfassen und zu zu Getting Started packen
        'plugins' => 'Plugin Installation',         // todo !!
        'packages' => 'Plugin Development',         // todo !! // evtl in Contribution Guide verschieben
    ],
    'Appendix' => [
        'releases' => 'Release Notes',              // bereits Korrektur gelesen
        'directories' => 'Directory Structure',
        'contributions' => 'Contribution Guide',    // bereits Korrektur gelesen // todo Die Philosophie auflisten, Link für Plugin hinterlegen, Link für Git Workflow, Pull Request erwähnen
        'git' => 'Git Guide',                       // todo in den Block verschieben
        'facades' => 'Facades',
        'scaffolder' => 'Scaffolder',
        'rest' => 'REST Service',                   // inkl. Clients, evtl zu "Getting Started" packen
        'soap' => 'SOAP Service',                   // inkl. Clients, evtl zu "Getting Started" packen
        'websocket' => 'WebSockets',                // inkl. Clients, evtl zu "Getting Started" packen
        'scheduler' => 'Scheduler',
        'daemons' => 'Daemons',
    ],

];