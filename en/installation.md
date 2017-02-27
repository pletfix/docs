# Installation

[Since 0.5.0]

- [Requirements](#requirements)
- [Installing Pletfix Application Skeleton](#installation)
- [Web Server Configuration](#web-server)
    - [Apache](#apache)
    - [Nginx](#nginx)

<a name="requirements"></a>
## Requirements

The Pletfix framework has a few system requirements:

- PHP >= 5.6.4
- [Composer](https://getcomposer.org/)
- [NPM/Bower Dependency Manager for Composer](https://github.com/fxpio/composer-asset-plugin/blob/master/Resources/doc/index.md) (a global scope installation is required!)

<a name="installation"></a>
## Installing Pletfix Application

![Fresh Pletfix Application](https://raw.githubusercontent.com/pletfix/docs/master/images/pletfix_application.png)

1. Download files

    Install Pletfix by entered the Composer create-project command in your terminal:
    
    ~~~
    composer create-project pletfix/app --repository=https://raw.githubusercontent.com/pletfix/app/master/packages.json my-project-name
    ~~~
    
    The command above will create a fresh Pletfix Application in the directory you specify (here "my-project-name").
    
    At the end it will ask you "Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]?", something you should answer with Y(es).

2. Directory Permissions

    After download Pletfix, you may create the folder `storage` with following subfolders:
    
    ~~~
    storage/
        cache/
        logs/
    ~~~
    
    **Important:** All directories within the storage have to be writable by your web server! 
    
    You may change the permissions as below:
    
    ~~~
    cd storage
    chgrp www-data *
    chmod 775 *
    chmod g+s *
    ~~~

3. Environment

    Rename the file `.env.example` to `.env`and modify the entries as you need.
 
4. Additional Configuration

    Customize the configuration files stored in `config` folder.

5. That's all! Now the application is ready for the first request.

    Open your browser and enter the URL of the application's public folder, e.g.
    
    ~~~
    http://localhost/my-app/public/
    ~~~
    
<a name="web-server"></a>
## Web Server Configuration

<a name="apache"></a>
### Apache

Enable the `mod_rewrite` module so the `.htaccess` file in the `public` folder will be loaded correctly by the apache server.

<a name="nginx"></a>
### Nginx

If you are using Nginx, the following directive in your site configuration will direct all requests to the `index.php` front controller:

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
