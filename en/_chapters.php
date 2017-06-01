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
        'index' => 'Overview, Licenses',
        'installation' => 'Installation',
        'upgrade' => 'Upgrade Guide',
        'hello' => 'Hello World',                   // todo "Create a Table", "Add a Model" beschreiben
    ],
    'General' => [ // General Topics
        'cache' => 'Cache',                         // todo Kapitel ändern: "Introduction" ("Configuration", "Creating Cache"), "Available Methods"
        'collections' => 'Collections',             // todo Korrektur lesen, kennzeichnen, welche Funktionen mutable sind
        'configuration' => 'Configuration',
        'commands' => 'Commands',                   // todo Korrektur lesen, Ausformulieren, Querverweise setzen
        'controllers' => 'Controllers',             // todo Korrektur lesen
        'datetime' => 'DateTime',                   // todo Korrektur lesen
        'di' => 'Dependency Injection',             // todo Korrektur lesen
        'errors' => 'Errors &amp; Exceptions',      // todo Korrektur lesen
        'flash' => 'Flash',                         // todo Korrektur lesen
        'helpers' => 'Helpers &amp; Services',      // todo Korrektur lesen
        'plugins' => 'Plugins',
        'requests' => 'HTTP Requests',              // todo Korrektur lesen, "various ways to get the url" in der Einführung
        'responses' => 'HTTP Responses',            // todo Korrektur lesen
        'routing' => 'HTTP Routing',                // todo Korrektur lesen
        'logging' => 'Logging',                     // todo Korrektur lesen
        'mailer' => 'Mailer',
        'events' => 'Notification Events',          // Not implemented yet!
        'sessions' => 'Sessions',                   // todo Korrektur lesen
        'testing' => 'Testing',
    ],
    'Frontend' => [
        'views' => 'Views',                         // todo Korrektur lesen
        'blade' => 'Blade Templates',               // todo Korrektur lesen
        'assets' => 'Asset Manager',
        'localization' => 'Localization',           // todo Korrektur lesen
        'forms' => 'Forms',                         // todo Korrektur lesen, Validation
        'cookies' => 'Cookies',                     // todo Korrektur lesen evtl nach Request und Response verlegen (s. https://laravel.com/docs/5.4/requests#cookies)
    ],
    'Database' => [
        'database' => 'Database Access Layer',      // todo Korrektur lesen, Misc und Scheam ausformulieren
        'builder' => 'Query Builder',               // todo Korrektur lesen
        'models' => 'Models',                       // todo Korrektur lesen, Validation
        'pagination' => 'Pagination',               // Not implemented yet!, evtl zu Frontend hinzufügen
        'migrations' => 'Migrations',
    ],
    'Security' => [
        'authentication' => 'Authentication',       // Not implemented yet!
        'ldap' => 'ldap',                           // Not implemented yet!
        'oauth' => 'OAuth',                         // Not implemented yet!, evt. umbenennen in Global Token Authentication
        'middleware' => 'Middleware',               // todo Korrektur lesen
        'csrf' => 'CSRF Protection',                // Not implemented yet!
    ],
    'Appendix' => [
        'releases' => 'Release Notes',
        'directories' => 'Directory Structure',     // todo Übersetzen
        'contributions' => 'Contribution Guide',    // todo Link für Git Workflow, Pull Request erwähnen
        'git' => 'Git Guide',                       // todo in den Block verschieben
        'lifecycle' => 'Lifecycle',                 // todo Auf Request- und Repsonse-Objekt eingehen
        'facades' => 'Facades',
        'scaffolder' => 'Scaffolder',               // Not implemented yet!
        'rest' => 'REST Service',                   // Not implemented yet!, inkl. Clients, evtl zu "Getting Started" packen
        'soap' => 'SOAP Service',                   // Not implemented yet!, inkl. Clients, evtl zu "Getting Started" packen
        'websocket' => 'WebSockets',                // Not implemented yet!, inkl. Clients, evtl zu "Getting Started" packen
        'scheduler' => 'Scheduler',                 // Not implemented yet!
        'daemons' => 'Daemons',                     // Not implemented yet!
    ],

];