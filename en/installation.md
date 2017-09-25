# Installation

[Since 0.5.0]

- [Requirements](#requirements)
- [Installing Pletfix Application Skeleton](#installation)
- [Customizing](#customizing)
- [Trouble Shooting](#trouble-shooting)
- [Web Server Configuration](#web-server)
    - [Apache](#apache)
    - [Nginx](#nginx)

![Screenshot - Pletfix Application](https://raw.githubusercontent.com/pletfix/docs/master/images/pletfix_application.png)

<a name="requirements"></a>
## Requirements

The Pletfix framework has a few system requirements:

- PHP >= 5.6.4
- [Composer](https://getcomposer.org/)
- [NPM/Bower Dependency Manager for Composer](https://github.com/fxpio/composer-asset-plugin/blob/master/Resources/doc/index.md) (a global scope installation is required!)

<a name="installation"></a>
## Installing Pletfix Application Skeleton

Install Pletfix by entering the Composer's create-project command in your terminal:

<!--
    composer create-project pletfix/app --repository=https://raw.githubusercontent.com/pletfix/app/master/packages.json my-project-name
-->
    
    composer create-project pletfix/app my-project-name

The command above creates a directory you specify (here "my-project-name") and downloads the package in this folder.

![Screenshot - Installation started](https://raw.githubusercontent.com/pletfix/app/master/resources/docs/screenshot_started.png)     

**Storage Folder**

After then, the installation procedure asks you about a file mode and group that should be used for the directories 
to be created in the storage folder.

Note, that the directories within the storage folder must be writable by your web server!

Enter "-" to skip this part. In this case you have to set the permissions after the installation procedure manually like 
this:
    
    cd storage
    chgrp www-data *
    chmod 775 *
    chmod g+s *

**Database**

In addition, you are asked if a SQLite database should be created.
If you answer yes, the migration procedure will be executed at the end of the installation.

**Remove VCS**

Composer loads all dependent packages into the vendor folder. It could take a few minutes.

At the end it will ask you "Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]?". You should answer 
with **Y** (the default).

![Screenshot - Installation completed](https://raw.githubusercontent.com/pletfix/app/master/resources/docs/screenshot_completed.png)     

That's all! Now the application is ready for the first request. 

Open your browser and enter the URL of the application's public folder, e.g.
    
    http://localhost/my-app/public/
    
    
<a name="customizing"></a>    
## Customizing

### Environment

After you have installed Pletfix, modify the entries in the environment file `.env` as you need. 

Because this file typically contains sensitive data, e.g. Passwords, it must not be pushed into your repository! 
Therefore, be sure, that this file is registered in `.gitignore`.
 
### Additional Configuration

Customize the configuration files stored in `config` folder.
    
    
<a name="web-server"></a>
## Web Server Configuration

<a name="apache"></a>
### Apache

Enable the `mod_rewrite` module so the `.htaccess` file in the `public` folder will be loaded correctly by the apache 
server.

<a name="nginx"></a>
### Nginx

If you are using Nginx, the following directive in your site configuration will direct all requests to the `index.php` 
front controller:

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }


<a name="trouble-shooting"></a>    
## Trouble Shooting

"Your requirements could not be resolved to an installable set of packages."
       
![Screenshot - Error Message](https://raw.githubusercontent.com/pletfix/app/master/resources/docs/screenshot_error.png)        

If you receive this error message during installation, [NPM/Bower Dependency Manager for Composer](https://github.com/fxpio/composer-asset-plugin/blob/master/Resources/doc/index.md) 
may not be installed. Note, that a **global scope installation** of this Dependency Manager is required!
