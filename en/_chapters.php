<?php

/**
 * Table of Contents
 */

// todo:
// Core Concept => zu Prologue packen oder Getting Started?
// Unterpunkte:
    // DI
    // HTTP Routing
    // Error Handling
    // Controllers
    // Services

// Revision Mark einführen:
// [Revision 0.6.3]

return [

    'Getting Started' => [
        'index' => 'Overview',                      // bereits Korrektur gelesen  // todo: Allgemeine Beschreibung, wie die Anwendung funktioniert, MVC, DI, usw..., alle Third Party auflisten
        'installation' => 'Installation',
        'upgrade' => 'Upgrade Guide',               // bereits Korrektur gelesen
        'lifecycle' => 'Lifecycle',                 // todo: Auf Request- und Repsonse-Objekt eingehen
        'hello' => 'Hello World',                   // todo "Create a Table", "Add a Model" beschreiben
        'testing' => 'Testing',
    ],
    'General' => [ // General Topics
        'cache' => 'Cache',                         // todo Kapitel ändern: "Introduction" ("Configuration", "Creating Cache"), "Available Methods"
        'collections' => 'Collections',             // todo kennzeichnen, welche Funktionen mutable sind
        'configuration' => 'Configuration',
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
    // todo ab hier überarbeiten
    'Database' => [
        'database' => 'Database Access Layer',      // todo !!
        'models' => 'Models',                       // todo !!
        'queries' => 'Query Builder',               // todo !! // evtl zu Models packen
        'pagination' => 'Pagination',               // todo !! // evtl zu Frontend hinzufügen
        'migrations' => 'Migrations',               // todo !!
        'seeding' => 'Seeding',                     // todo !! // evtl zu migrations packen
    ],
    'Security' => [
        'authentication' => 'Authentication',       // todo !!
        'oauth2' => 'OAuth2', // Global Token Authentication    // todo !!
        'middleware' => 'Middleware',               // todo !!
        'csrf' => 'CSRF Protection',                // todo !!
    ],
    'Command Line Interface' => [                   // evtl alles zusammenfassen und zu Generals packen
        'console' => 'Console', // Commands         // todo !!
        'stdio' => 'Stdio',                         // todo !!
        'scheduler' => 'Scheduler',                 // todo !!
        'daemons' => 'Daemons',                     // todo !!
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
    ],

];