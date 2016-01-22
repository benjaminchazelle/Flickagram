csZendApplication
=================

Introduction
------------

This is a simple, web application using the ZF2 MVC layer and module systems. 

Installation
------------

### Get the project

Clone the project from the git repository available at https://github.com/benjaminchazelle/csZendApplication.git

### Configure your web server

You have to setup a virtual host to point to the public/ directory of the project.

If you use Apache server, add a virtual host at the end of the httpd.conf, it should look something like below:

    <VirtualHost *:80>
        ServerName zend.local
        DocumentRoot /path/to/csZendApplication/public
        <Directory /path/to/csZendApplication/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
            <IfModule mod_authz_core.c>
            Require all granted
            </IfModule>
        </Directory>
    </VirtualHost>


### SQL installation

SQL scripts are available in install direcotry.

You can import in your database the minimal SQL structure by choosing install-structure.sql

Nevertheless, demonstration accounts and flicks are pre filled in the install-structure+data.sql     <--- Monsieur prenez ce fichier

Import the script you've choosed in your database.

### Database connection configuration

Set the database connection informations (host, schema, username, password) by editing config/autoload/local.php and config/autoload/global.php.


### Let's play !

By default if you have installed install-structure+data.sql file, you can log to the application with :

    username:    alice@mail.com, bob@mail.com, charles@mail.com, derik@mail.com, elise@mail.com, or fabrice@mail.com
    password:    aqwzsx
	