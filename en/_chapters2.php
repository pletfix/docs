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

return [

    'Prologue' => [
        'index' => 'Overview',
        'releases' => 'Release Notes',
        'upgrade' => 'Upgrade Guide',
        'contributions' => 'Contribution Guide',    // todo Die Philosophie auflisten
    ],
    // ab hier Korrektur lesen (englisch)
    'Getting Started' => [
        'installation' => 'Installation',
        'hello' => 'Hello World',                   // todo nur teilweise fertig
        'scaffolder' => 'Scaffolder',
        'testing' => 'Testing',
    ],
    'Core Concept' => [
        'concept' => 'Core Concept',                // todo
        'directories' => 'Directory Structure',
        'di' => 'Dependency Injection',             // todo
        'lifecycle' => 'Lifecycle',                 // todo: Auf Request- und Repsonse-Objekt eingehen
        'errors' => 'Error &amp; Exception Handling', // todo
        'controllers' => 'Controllers',             // todo
        'services' => 'Services',                   // todo
    ],
    'General' => [ // General Topics
        'cache' => 'Cache',                         // todo Kapitel ändern: "Introduction" ("Configuration", "Creating Cache"), "Available Methods"
        'collections' => 'Collections',             // todo kennzeichnen, welche Funktionen mutable sind
        'datetime' => 'DateTime',                   // todo (Planned release: 0.5.4)
        'facades' => 'Facades',
        'helpers' => 'Helpers',                     // todo services.php hinzufügen
        'requests' => 'HTTP Requests',              // todo "various ways to get the url" in der Einführung
        'responses' => 'HTTP Responses',
        'routing' => 'HTTP Routing',                // todo Baustelle bei "Optional Params"
        'logging' => 'Logging',
        'mailer' => 'Mailer',
        'rest' => 'REST Service',                   // inkl. Clients, evtl zu "Getting Started" packen
        'soap' => 'SOAP Service',                   // inkl. Clients, evtl zu "Getting Started" packen
        'websocket' => 'WebSockets',                // inkl. Clients
        'events' => 'Notification Events',
        'sessions' => 'Sessions',
    ],
    'Frontend' => [
        'views' => 'Views',
        'blade' => 'Blade Templates',
        'assets' => 'Asset Manager',        // bereits Korrektur gelesen (englisch)
        'localization' => 'Localization',
        // todo ab hier überarbeiten
        'forms' => 'Forms',
        'validation' => 'Validation',       // evtl zu Forms packen
    ],
    'Database' => [
        'database' => 'Database Access Layer',
        'models' => 'Models',
        'queries' => 'Query Builder', // evtl zu Models packen
        'pagination' => 'Pagination',
        'migrations' => 'Migrations',
        'seeding' => 'Seeding', // evtl zu migrations packen
    ],
    'Security' => [
        'authentication' => 'Authentication',
        'oauth2' => 'OAuth2', // global token authentication
        'middleware' => 'Middleware',
        'csrf' => 'CSRF Protection',
    ],
    'Command Line Interface' => [ // evtl alles zusammenfassen und zu zu General Topics packen
        'console' => 'Console', // oder Commands
        'stdio' => 'Stdio',
        'scheduler' => 'Scheduler',
        'daemons' => 'Daemons',
    ],
    'Plugin Management' => [ // evtl beides zusammenfassen und zu zu Getting Started packen
        'plugins' => 'Plugin Installation',
        'packages' => 'Plugin Development',
    ],
    'Appendix' => [
        'plugins' => 'Plugin Installation',
        'packages' => 'Plugin Development',
    ],

];