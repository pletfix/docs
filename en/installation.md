# Installation

- [Requirements](#requirements)
- [Installing Pletfix Application Skeleton](#install)
- [Start the Application](#start)
- [Customizing](#customizing)
- [Web Server Configuration](#web-server)
    - [Apache](#apache)
    - [Nginx](#nginx)

![Screenshot - Pletfix Application](https://raw.githubusercontent.com/pletfix/docs/master/images/pletfix_application.png)

<a name="requirements"></a>
## Requirements

The Pletfix framework has just a few system requirements:

- Web server with URL rewriting
- PHP >= 5.6.4
- [Composer](https://getcomposer.org/)

<a name="install"></a>
## Installing Pletfix Application Skeleton

Install Pletfix by entering the Composer's create-project command in your terminal:

The latest stable release:

```bash
composer create-project pletfix/app myapp
```

The current development version (may be unstable):

```bash
composer create-project pletfix/app --stability=dev myapp
```

<!--
composer create-project pletfix/app --repository=https://raw.githubusercontent.com/pletfix/app/master/packages.json myapp
-->

> Pletfix uses the [Asset Packagist](https://asset-packagist.org/) by [HiQDev](https://hiqdev.com/) to download Bower and NPM packages via Composer. 
> It's licensed under [BSD 3-clause](https://github.com/hiqdev/asset-packagist/blob/master/LICENSE). 
> Thanks for this great work!

The command above creates a directory you specify (here "myapp") and downloads the package in this folder.

![Screenshot - Installation started](https://raw.githubusercontent.com/pletfix/app/master/resources/docs/screenshot_started.png)     

**Storage Folder**

After then, the installation procedure asks you about a file mode and group that should be used for the directories 
to be created in the storage folder.

Note, that the directories within the storage folder must be writable by your web server!

Enter "-" to skip this part. In this case you have to set the permissions after the installation procedure manually like 
this:
    
```bash    
cd storage
chgrp www-data *
chmod 775 *
chmod g+s *
```

**Database**

In addition, you are asked if a SQLite database should be created.
If you answer yes, the migration procedure will be executed at the end of the installation.

**Remove VCS**

Composer loads all dependent packages into the vendor folder. It could take a few minutes.

At the end it will ask you "Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]?". You should answer 
with **Y** (the default).

![Screenshot - Installation completed](https://raw.githubusercontent.com/pletfix/app/master/resources/docs/screenshot_completed.png)     

Now the application is ready for the first request. 

<a name="start"></a>
## Start the Application

Before you open the application with your browser, you should configure the document root of the web server to be the 
`public` directory.

If you have not installed a web server on your development environment, or if you do not have time or desire to  
configure your server, you can start up the PHP's built-in web server with the following command: 

```bash
php -S localhost:8000 -t public/ router.php
```

> Note, that the built-in web server should never be used in a production environment. It is only intended as a basic 
> development server!

That's all! This command will serve your application at `http://localhost:8000`.
  
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

For the production environment a web server with URL rewriting is required, e.g. Apache or Nginx.

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
