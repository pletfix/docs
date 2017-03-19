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
        'index' => 'Overview, Licenses',            // bereits Korrektur gelesen
        'installation' => 'Installation',           // bereits Korrektur gelesen
        'upgrade' => 'Upgrade Guide',               // bereits Korrektur gelesen
        'hello' => 'Hello World',                   // bereits Korrektur gelesen todo "Create a Table", "Add a Model" beschreiben
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
        'plugins' => 'Plugins',
        'requests' => 'HTTP Requests',              // todo "various ways to get the url" in der Einführung
        'responses' => 'HTTP Responses',
        'routing' => 'HTTP Routing',
        'logging' => 'Logging',
        'mailer' => 'Mailer',
        'events' => 'Notification Events',
        'sessions' => 'Sessions',
        'testing' => 'Testing',                     // bereits Korrektur gelesen
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
    'Appendix' => [
        'releases' => 'Release Notes',              // bereits Korrektur gelesen
        'directories' => 'Directory Structure',
        'contributions' => 'Contribution Guide',    // bereits Korrektur gelesen // todo Link für Git Workflow, Pull Request erwähnen
        'git' => 'Git Guide',                       // todo in den Block verschieben
        'lifecycle' => 'Lifecycle',                 // bereits Korrektur gelesen todo: Auf Request- und Repsonse-Objekt eingehen
        'facades' => 'Facades',
        'scaffolder' => 'Scaffolder',
        'rest' => 'REST Service',                   // inkl. Clients, evtl zu "Getting Started" packen
        'soap' => 'SOAP Service',                   // inkl. Clients, evtl zu "Getting Started" packen
        'websocket' => 'WebSockets',                // inkl. Clients, evtl zu "Getting Started" packen
        'scheduler' => 'Scheduler',
        'daemons' => 'Daemons',
    ],

];