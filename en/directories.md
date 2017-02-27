<style>
.tree {
    background-color: white; 
}
</style>
 
# Directory Structure

[Since 0.5.0]

- [Application Directory](#application)
- [Core Directory](#core)
- [Plugin Directory](#plugin)

<a name="application"></a>
## Pletfix Application Directory

<pre class="tree">
|-[base](#base)/
   |-[.manifest](#manifest)/    Manifest Dateien (werden durch bestimmte Konsolenbefehle generiert)
   |  |-assets/                 Informationen über die Versionierung der Assets
   |  |-plugins/                Informationen über die registrierten Plugins
   |-[app](#app)/               Autoload-Verzeichnis nach PSR-4-Standard, Namespace \App
   |  |-Commands/               Konsolenbefehle
   |  |-Controller/             Controller der Anwendung
   |  |-Exceptions/             Anwendungsspezifische Exception-Klassen
   |  |-Handler/                Event- und Exception-Handler
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
   |  |-hello.php               Konfigurationsdateien des Plugins "hello" (exemplarisch für eine Plugin Konfiguration)
   |  |-mail.php                Konfiguration des Mailers
   |-library/                   Daten, auf die die Anwendung serverseitig zugreift
   |  |-classes/                Klassen, die per Classmap geladen werden (weil diese nicht dem PSR-4-Standard folgen)
   |  |-facades/                Facaden (deprecated)
   |  |-functions/              Autoload-Verzeichnis für Funktionen (jede Datei muss einzeln in composer.json eingetragen werden!)
   |-public                     Daten, auf die die der Browser direkt zugreifen darf.
   |  |-build/                  Versionierte Assetdateien (werden durch den Asset-Manager generiert)
   |  |-css/                    Stylesheets
   |  |-fonts/                  Font-Dateien
   |  |-images/                 Bilder
   |  |-js/                     JavaScript
   |  |-.htaccess               Apache htaccess-Datei
   |  |-favicon.ico             Favcion für den Browser
   |  |-index.php               Einstiegspunkt für alle Web-Requests.
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
   |  |  |-de/                  Deutsche Überstzung
   |  |  |-en/                  Englische Überstzung
   |  |-migrations/             Migration-Dateien
   |  |-views/                  Views (werden beim ersten Zugriff kompiliert und im Cache abgelegt)
   |-storage/                   Für den Webservice beschreibbar (z.B. für Logfiles, Cache oder komilierte Views)
   |  |-cache/                  Cache (beinhaltet u.a. auch die  und Translator-Dateien)
   |  |  |-doctrine/            Speicherort für den Application Cache (Doctrine Adapter)
   |  |  |-lang/                Statische Translator-Dateien (wird beim ersten Zugriff aktualisiert, sofern nötig)
   |  |  |-views/               Kompilierte Views
   |  |  |-commands.php         Liste der verfügbaren Konsolenbefehle (wird von der CommandFactory generiert)
   |  |  |-config.php           Statische Konfigurationsdateien (wird beim Booten aktualisiert, sofern nötig)
   |  |-db/                     SQLite-Datenbank-Datei
   |  |-logs/                   Logdateien
   |  |-sessions/               Sessions
   |-tests/                     The tests directory contains your automated tests.
   |-vendor/                    Pletfix Core, Plugins and Third Party Packages - Don't modify this code!
   |-workbench/                 Folder for core or plugin developing
   |-.env                       Umgebungsvariablen (von git ausgeschlossen!)
   |-.env.example               Beispiel aller möglichen Umgebungsvariablen
   |-.gitignore                 Liste der von git ausgeschlossenen Dateien und Ordner
   |-composer.json              Composer Konfiguration
   |-composer.lock              Composer Lock File
   |-console                    Shell-Script zum Starten des Konsolenprogramms (ruft Core\Console auf)
   |-license.md                 Lizenzinformationen
   |-packages.json              Package Informationen (für Composer's create-project command)
   |-README.md                  Kurzanleitung zur Installation und Nutzung des Frameworks
</pre>

<a name="core"></a>
## Core Directory

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
         |  |-Controller/       AbstractController-Klasse
         |  |-Exceptions/       Exception-Klassen
         |  |-Models/           AbstractModel-Klasse
         |  |-Services/         Service-Klassen (werden im DI direkt oder indirekt bereitgestellt)
         |  |-Testing/          TestCase and MinkTestCase Definition
         |  |-Application.php   Webapplikation (leitet die Anfrage an die angeforde Route weiter)
         |  |-Console.php       Konsolenprogramm (lädt ein Konsolenbefehl und führt diesen aus)
         |-tests/               The tests directory contains your automated tests.
         |  |-bootstrap.php     Bootstrap for PHPUNit
         |-.gitignore           Liste der von git ausgeschlossenen Dateien und Ordner
         |-composer.json        Composer Konfiguration
         |-phpunit.xml.dist     PHPUnit Configuration File
         |-README.md            Kurzanleitung zur Installation und Nutzung des Frameworks
</pre>

<a name="plugin"></a>
## Plugin Directory

<pre class="tree">
|-vendor/
   |-foo/                       Vendor Name (hier "foo" als Beispiel)
      |-bar/                    Plugin Name (hier "bar" als Beispiel)
         |-assets/              Assets (werden vom Asset-Manager kompiliert und im Public-Ordner abgelegt)
         |  |-build.php         Asset Build Information File
         |-config/              Konfigurationsdateien
         |  |-routes.php        Routen des Plugins
         |  |-services.php      Registrierung der Services des Plugins
         |  |-config.php        Konfigurationsdatei des Plugins
         |-lang/                Translator-Dateien (werden beim ersten Zugriff kompiliert und im Cache abgelegt)
         |  |-de.php            Deutsche Überstzung
         |  |-en.php            Englische Überstzung
         |-migrations/          Migration-Dateien
         |-public               Dateien, die in den Public-Ordner der Anwendung kopiert werden
         |-src/                 Autoload-Verzeichnis nach PSR-4-Standard, Namespace \&lt;vendor&gt;\&lt;plugin&gt;
         |  |-Bootsraps         Plugin-spezifische Bootstrapper
         |  |-Commands          Konsolenbefehle
         |-tests/               The tests directory contains your automated tests.
         |-views/               Views (werden beim ersten Zugriff kompiliert und im Cache abgelegt)
         |-.gitignore           Liste der von git ausgeschlossenen Dateien und Ordner
         |-composer.json        Composer Konfiguration
         |-phpunit.xml.dist     PHPUnit Configuration File
         |-README.md            Kurzanleitung zur Installation und Nutzung des Plugins
</pre>

<!--
Vergleiche:
    http://guides.rubyonrails.org/getting_started.html
    https://book.cakephp.org/3.0/en/intro/cakephp-folder-structure.html
-->
