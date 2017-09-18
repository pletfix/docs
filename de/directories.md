<style>
.tree {
    background-color: white; 
}
</style>
 
# Verzeichnisstruktur

[Since 0.5.0]

- [Pletfix-Anwendung](#application)
- [Core Verzeichnis](#core)
- [Plugin Verzeichnis](#plugin)

<a name="application"></a>
## Pletfix-Anwendung

<pre class="tree">
|-[base](#base)/
   |-[.manifest](#manifest)/    Manifest Dateien (werden durch bestimmte Konsolenbefehle generiert)
   |  |-assets/                 Informationen über die Versionierung der Assets
   |  |-plugins/                Informationen über die registrierten Plugins
   |-[app](#app)/               Autoload-Verzeichnis nach PSR-4-Standard, Namespace \App
   |  |-Commands/               Konsolenbefehle
   |  |-Controllers/            Controller der Anwendung
   |  |-Drivers/                Treiber (können durch Factories geladen werden)
   |  |-Exceptions/             Anwendungsspezifische Exception-Klassen
   |  |-Handler/                Event- und Exception-Handler
   |  |-Middleware/             Middleware der Anwendung
   |  |-Models/                 Models der Anwendung
   |  |-Services/               Anwendungsspezifische Service (werden im DI direkt oder indirekt bereitgestellt)
   |-config/                    Konfigurationsdateien
   |  |-boot/                   Wird bereits beim Boot-Vorgang geladen
   |  |  |-bootstrap.php        Auflistung der für die Anwendung aktiven Bootstrapper
   |  |  |-routes.php           Routen der Anwendung
   |  |  |-services.php         Registrierung der anwendungsspezifischen Services
   |  |-app.php                 Gundlegende Konfiguration der Anwendung
   |  |-cache.php               Konfiguration des Caches
   |  |-database.php            Konfiguration der Datenbank(en)
   |  |-hello.php               Konfigurationsdateien des Plugins "hello" (exemplarisch)
   |  |-mail.php                Konfiguration des Mailers
   |  |-session.php             Konfiguration der PHP-Session
   |-library/                   Daten, auf die die Anwendung serverseitig zugreift
   |  |-classes/                Klassen, die per Classmap geladen werden (weil diese nicht dem PSR-4-Standard folgen)
   |  |-facades/                Facaden (veraltet)
   |  |-functions/              Autoload-Verzeichnis für Funktionen (jede Datei muss einzeln in composer.json eingetragen werden)
   |  |  |-helpers.php          Helper-Funktionen
   |-public                     Daten, auf die die der Browser direkt zugreifen darf
   |  |-build/                  Versionierte Asset-Dateien (werden durch den Asset-Manager generiert)
   |  |-css/                    Stylesheets
   |  |-fonts/                  Font-Dateien
   |  |-images/                 Bilder
   |  |-js/                     JavaScript
   |  |-.htaccess               Apache htaccess-Datei
   |  |-favicon.ico             Favicon für den Browser
   |  |-index.php               Einstiegspunkt für alle Web-Requests
   |  |-php.ini                 PHP Direktiven für Webhoster
   |  |-robots.txt              Robot-File
   |  |-sitemap.xml             Sitemap der Anwendung
   |-resources/                 Daten, auf die die Anwendung nur indirekt oder gar nicht zugreift
   |  |-assets/                 Daten, die per Asset-Manager in den Public-Ordner kopiert werden
   |  |  |-css/                 Stylesheets
   |  |  |-fonts/               Font-Dateien
   |  |  |-js/                  JavaScript
   |  |  |-less/                Less-Dateine (wird durch den Asset-Manager zur CSS-Datei kompiliert)
   |  |  |-sass/                SASS-Dateien (wird durch den Asset-Manager zur CSS-Datei kompiliert)
   |  |  |-scss/                SCSS-Dateien (wird durch den Asset-Manager zur CSS-Datei kompiliert)
   |  |  |-build.php            Asset Build Information File
   |  |-docs/                   Dokumente
   |  |-lang/                   Translator-Dateien (werden beim ersten Zugriff kompiliert und im Cache abgelegt)
   |  |  |-de/                  Deutsche Übersetzung
   |  |  |-en/                  Englische Übersetzung
   |  |-migrations/             Migration-Dateien
   |  |-views/                  Views (werden beim ersten Zugriff kompiliert und im Cache abgelegt)
   |-storage/                   Daten, die während der Laufzeit erstellt wurden (Ordner ist beschreibbar, ignoriert von git)
   |  |-cache/                  Cache
   |  |  |-doctrine/            Speicherort für den Application Cache (Doctrine Adapter)
   |  |  |-lang/                Statische Translator-Dateien (wird beim ersten Zugriff aktualisiert, sofern nötig)
   |  |  |-views/               Kompilierte Views
   |  |  |-commands.php         Liste der verfügbaren Konsolenbefehle (wird von der CommandFactory generiert)
   |  |  |-config.php           Statische Konfigurationsdateien (wird beim Booten aktualisiert, sofern nötig)
   |  |-db/                     SQLite-Datenbank-Datei
   |  |-logs/                   Logdateien
   |  |-sessions/               Sessions
   |-tests/                     Beinhaltet die Unit-Tests
   |-vendor/                    Pletfix Core, Plugins und Packages von Drittanbietern - Ändern Sie diesen Code nicht!
   |-workbench/                 Ordner für Kern- oder Plugin-Entwicklung
   |-.env                       Umgebungsvariablen (von git ausgeschlossen)
   |-.env.example               Beispiel aller möglichen Umgebungsvariablen
   |-.gitignore                 Liste der von git ausgeschlossenen Dateien und Ordner
   |-composer.json              Composer Konfiguration
   |-composer.lock              Composer Lock-Datei
   |-console                    Shell-Script zum Starten des Konsolenprogramms (ruft Core\Console auf)
   |-LICENSE                    Lizenzinformationen
   |-phpunit.xml                Konfiguration der Testumgebung (von git ausgeschlossen)
   |-phpunit.xml.dist           Konfiguration der Testumgebung (fallback, falls phpunit.xml nicht existiert)
   |-packages.json              Package Informationen (für Composer's create-project command)
   |-README.md                  Kurzanleitung zur Installation und Nutzung des Frameworks
</pre>

<a name="core"></a>
## Core Verzeichnis

<pre class="tree">
|-vendor/
   |-pletfix/
      |-core/
         |-bin/                 Binaries
         |  |-hiddeninput.exe   Wird unter Windows für eine Hiddeneingabe in Konsolenprogrammen benötigt
         |-functions/           Funktionen, die automatisch geladen werden
         |  |-helpers.php       Hilfsfunktionen für Views
         |  |-services.php      Funktionen, die den Zugriff auf die Service vereinfacht
         |-src/                 Autoload-Verzeichnis nach PSR-4-Standard, Namespace \Core
         |  |-Bootsraps/        Bootstrapper
         |  |-Commands/         Konsolenbefehle
         |  |-Controllers/      AbstractController-Klasse
         |  |-Exceptions/       Exception-Klassen
         |  |-Middleware/       Middleware-Klassen
         |  |-Models/           AbstractModel-Klasse
         |  |-Services/         Service-Klassen (werden im DI direkt oder indirekt bereitgestellt)
         |  |-Testing/          TestCase and MinkTestCase Definition
         |  |-Application.php   Webapplikation (leitet die Anfrage an die angeforde Route weiter)
         |  |-Console.php       Konsolenprogramm (lädt ein Konsolenbefehl und führt diesen aus)
         |-tests/               Beinhaltet die Unit-Tests
         |  |-bootstrap.php     Bootstrap for PHPUNit
         |-composer.json        Composer Konfiguration
         |-helpers.php          Helper-Funktionen
         |-LICENSE              Lizenzinformationen
         |-phpunit.xml.dist     Konfiguration der Testumgebung
         |-README.md            Kurzanleitung zur Installation und Nutzung des Frameworks
</pre>

<a name="plugin"></a>
## Plugin Verzeichnis

<pre class="tree">
|-vendor/
   |-foo/                       Vendor Name (hier "foo" als Beispiel)
      |-bar/                    Plugin Name (hier "bar" als Beispiel)
         |-assets/              Dateien, die vom Asset-Manager kompiliert und im Public-Ordner abgelegt werden
         |  |-build.php         Asset Build Information File
         |-config/              Konfigurationsdateien
         |  |-routes.php        Routen des Plugins
         |  |-services.php      Registrierung der Services des Plugins
         |  |-config.php        Konfigurationsdatei des Plugins
         |-lang/                Translator-Dateien (werden beim ersten Zugriff kompiliert und im Cache abgelegt)
         |  |-de.php            Deutsche Überstzung
         |  |-en.php            Englische Überstzung
         |-migrations/          Migration-Dateien
         |-public/              Dateien, die in den Public-Ordner der Anwendung kopiert werden
         |-src/                 Autoload-Verzeichnis nach PSR-4-Standard, Namespace \&lt;vendor&gt;\&lt;plugin&gt;
         |  |-Bootstraps/       Plugin-spezifische Bootstrapper
         |  |-Commands/         Konsolenbefehle
         |  |-Controllers/      Controller-Klassen
         |  |-Drivers/          Treiber (können durch Factories geladen werden)
         |  |-Middleware/       Middleware-Klassen
         |  |-Services/         Service-Klassen (werden im DI direkt oder indirekt bereitgestellt)
         |-tests/               Beinhaltet die Unit-Tests
         |-views/               Views (werden beim ersten Zugriff kompiliert und im Cache abgelegt)
         |-.gitignore           Liste der von git ausgeschlossenen Dateien und Ordner
         |-composer.json        Composer Konfiguration
         |-LICENSE              Lizenzinformationen
         |-phpunit.xml.dist     Konfiguration der Testumgebung
         |-README.md            Kurzanleitung zur Installation und Nutzung des Plugins
</pre>

<!--
Vergleiche:
    http://guides.rubyonrails.org/getting_started.html
    https://book.cakephp.org/3.0/en/intro/cakephp-folder-structure.html
-->
