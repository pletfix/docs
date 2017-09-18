# Assets

_Arbeiten mit Bildern, Skripten, CSS-Dateien_

[Since 0.5.0]

- [Einleitung](#introduction)
- [Asset Build Definition](#definition)
    - [JavaScript](#scripts)
    - [Stylesheets](#stylesheets)
    - [Dateien & Verzeichnissen kopieren](#copying)
- [Assets veröffentlichen](#publishing)    
- [Assets entfernen](#removing)
- [Plugin Optionen](#plugin)
- [Verwendung in Views](#usage)

<a name="introduction"></a>
## Einleitung

Pletfix bietet ein einfaches Asset-Pipeline-Tool zum Publizieren von Stylesheets, JavaScripts und anderen Assets.

Du kannst deine Assets sehr einfach in `resources/assets/build.php` definieren und mit dem Pletfix-Kommando `asset` 
veröffentlichen. Der Befehl kompiliert, minimiert und verkettet die Assets, speichert sie im `public` Ordner und 
fügt dem Dateinamen für Cache Busting ein eindeutiges Token hinzu.

Unter der Haube benutzt Pletfix folgende Werkzeuge:

- Javascript Minifier: [JShrink](https://github.com/tedious/JShrink) von Robert Hafner, lizenziert unter [BSD-Lizenz](https://github.com/tedious/JShrink/blob/master/LICENSE).
- Stylesheet Minifier: [Klon von CssMin](https://github.com/natxet/cssmin). Das Original [CssMin](https://code.google.com/archive/p/cssmin/) von Joe Scylla ist lizenziert unter [MIT-Lizenz](https://opensource.org/licenses/mit-license.php).
- Less Compiler: [Less.php](https://github.com/oyejorge/less.php) von Josh Schmidt, ein PHP-Port des officiellen [LESS-Prozessors](http://lesscss.org), lizenziert unter [Apache-Lizenz](https://github.com/oyejorge/less.php/blob/master/LICENSE).
- SCSS Compiler: [scssphp](http://leafo.github.io/scssphp/) von Leaf Corcoran, lizenziert unter [MIT-Lizenz](https://raw.githubusercontent.com/leafo/scssphp/master/LICENSE.md). Siehe auch [scssphp auf GitHub](https://github.com/leafo/scssphp).

<a name="definition"></a>
## Asset Build Definition

Du kannst deine Assets in `resources/assets/build.php` definieren. Es sieht wie folgt aus:

    return [
        'js/app.js' => [
            vendor_path('vendor/npm-asset/jquery/dist/jquery.min.js'),
            vendor_path('npm-asset/bootstrap/dist/js/bootstrap.min.js'),
            resource_path('assets/js/base.js'),
        ],
        'css/app.css' => [
            resource_path('assets/less/base.less'),
        ],
        'fonts' => [
            vendor_path('npm-asset/bootstrap/dist/fonts'),
            resource_path('assets/fonts/fonts.gstatic.com_lato.woff2'),
        ],
    ];
  
Pletfix unterstützt JavaScript, stylesheets und andere Dateienwie Fonts oder Bilder, die in den `public` Ordner 
veröffentlicht werden sollen.

<a name="scripts"></a>
### JavaScript

Wenn du eine oder mehrere JavaScript-Dateien minimieren oder zu einer einzigen Datei zusammenfassen möchtest, kannst du
sie folgendermaßen definieren:

    'path/to/dest.min.js' => [
        'path/to/source.js',
        'path/to/second-script.js',
        'path/to/folder',
    ],


Die Zieldatei auf der linken Seite ist relativ zum `public` Ordner und benötigt als Dateiendung `.js`. 
Die Quellliste auf der rechten Seite sollte JavaScript-Dateien oder Ordner mit einem absoluten oder relativen Pfad zum 
[base path](helpers#method-base-path) enthalten. Dateien in den Ordnern, die nicht JavaScript sind, werden ignoriert.

<a name="stylesheets"></a>
### Stylesheets

Wenn du einige Stylesheets minimieren und zu einer einzigen Datei zusammenfassen möchtest, kannst du sie wie folgt 
verwenden:

    'path/to/dest.min.css' => [
        'path/to/source.css',
        'path/to/scss-file.scss',
        'path/to/less-file.less',
        'path/to/folder',
    ],

Note that the destination file on the left side must have `.css` as file extension and the source list on the right side 
should contain CSS, SCSS, Less files and folders. Only stylesheets are substantial in the folder.
Beachten Sie, dass die Zieldatei auf der linken Seite als Dateiendung `.css` haben muss und die Quell-Liste auf der 
rechten Seite CSS, SCSS, Less Dateien oder Ordner enthalten sollte. In den Ordner werden nur Stylesheets berücksichtigt.

<a name="copying"></a>
### Dateien & Verzeichnissen kopieren

If you like to just copy some files to the `public` folder, write entries in `resources/assets/build.php` like this: 
Wenn du nur einige Dateien in den öffentlichen Ordner kopieren möchtest, schreibe die Einträge in `resources/assets/build.php` wie folgt:

    'subpath' => [
        'path/to/a/image.png',
        'path/to/readme.md',
        'path/to/folder'
    ],

Beachten, dass das Ziel ein Ordner in diesem Beispiel ist. In diesem Fall werden alle Dateien und Verzeichnisse auf 
der rechten Seite in den Zielordner kopiert, anstatt zu einer einzigen Datei verkettet zu werden.

Natürlich ist es auch möglich, einige Nicht-JS-Dateien bzw. Nicht-CSS-Dateien zu einer einzigen Datei zu verknüpfen.

<a name="publishing"></a>
## Assets veröffentlichen

Du kannst in deinem Terminal den folgenden Pletfix-Befehl eingeben, um alle Assets zu erstellen, die du in deiner 
Anwendung definiert hast:

    php console asset
    
Wenn du nur einen bestimmten Asset erstellen möchtest, gib den Namen der Zieldatei an:
     
    php console asset css/app.css  

Der Befehl `asset` führt folgende Schritte aus:

1. **Kompilieren**: Wenn die Quelldatei eine SCSS- oder Less-Datei ist, kompiliert der Asset-Befehl diese Datei in eine einfache CSS-Datei.                    
2. **Minimieren** JavaScript und Stylesheets werden minimiert, so dass diese schneller an den Client ausgeliefert werden können.
3. **Zusammenfügen**: Wenn das Ziel kein Ordner, sondern eine Datei ist, fügt `asset` die minimierten Dateien zu einer einzigen Datei zusammen.    
4. **Copy**: Abschließend kopiert `asset` die zusammengefügte Datei oder die ursprünglichen Quelldateien in den Zielordner unterhalb von `public`.
5. **Cache Busting**: Zusätzlich wird die Zieldatei mit einem eindeutigen Hash-Schlüssel versehen und im Ordner `public/build`gespeichert.
                      
Wenn Sie die Datei nicht minimieren möchten, setzen Sie die Option 'no-minify': 
 
    php console asset css/app.css --no-minify
 
      
<a name="removing"></a>
## Assets entfernen
               
Wenn du ein bereits publiziertes Asset entfernen möchten, gib dies in deinem Terminal ein:
 
    php console asset css/app.css --remove
 
 
<a name="plugin"></a>
## Plugin-Optionen
 
Du kannst alle Assets oder nur eine bestimmte Asset aus einem Plugin manuell kompilieren. Dazu musst du nur die Option 
'plugin' mit dem Namen des Plugins (ohne Vendor) setzen:
 
    php console asset css/app.css --plugin=hello
               
Du kannst die Optionen `plugin` und `remove` auch zusammen verwenden, um alle Assets eines Plugins zu entfernen:
 
    php console asset --remove --plugin=hello
 
> Normally you don't need the `plugin` option to publish or remove the assets because it's happening automatically 
> when you install or remove a plugin with the [Pletfix's plugin command](plugins).

> Normalerweise benötigst du die Option `plugin` zum Veröffentlichen und Entfernen der Assets nicht, da dies automatisch 
geschieht, wenn du ein Plugin mit dem Plugin-Befehl von Pletfix installierst bzw. entfernst.


<a name="usage"></a>
## Verwendung in Views

Du kannst die Helfer-Funktion `asset()` verwenden, um das entsprechend gehashte Objekt in die View zu laden.
Setze die Asset-Datei relativ zum Ordner `public` als Argument von `asset()`. Die Funktion ermittelt automatisch den 
aktuellen Namen der Hash-Datei:

    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

Wenn keine entsprechende Hash-Datei in `public/build` existiert, wird die Originaldatei geladen.