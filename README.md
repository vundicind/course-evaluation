courseeval
=================

A course evaluation system for [USARB](http://www.usarb.md).

Installation
------------

Initialize the application:

### Debian

```sh
./init
cp provision/*-local.php common/config/
```

### Windows

```sh
php.exe init
copy provision\*-local.php common\config\
```

In _common/config/main-local.php_ update database settings.

Update all the dependencies:

### Debian

```sh
bin/composer install
```

### Windows

```sh
php.exe bin/composer install
```

In case of errors [patch](http://blogyii.com/blog/undefined-method-csrfmetatags) the composer

### Debian

```sh
bin/composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
```

Make sure you have `mcrypt` installed and enabled.

### Debian

```sh
sudo apt-get install php5-mcrypt
sudo php5enmod mcrypt
sudo service apache2 restart
```

Run db migration for [pheme/yii2-settings](http://github.com/pheme/yii2-settings) extension:

### Windows

```sh
php.exe yii migrate/up --migrationPath=vendor/yii2-settings/migrations
```

Make all db migrations:

### Debian

```sh
./yii migrate
```

### Windows

```sh
php.exe yii migrate
```

Configure web server:

### Debian

```sh
cd /etc/apache2/conf-available
ln -s /opt/courseeval/provision/apache2.conf courseeval.conf
a2enconf courseeval
service apache2 reload
```

### Windows (XAMPP)

```sh
copy provision\httpd-courseeval.conf C:\xampp\apache\conf\extra\
```

In file _C:\xampp\apache\conf\httpd.conf_, at the end of file, add the lines:

```
# courseeval settings
Include "conf/extra/httpd-courseeval.conf"
``` 

You can test now enetering in the browser the address:

http://localhost/courseeval/

or 

http://localhost/courseeval-admin/
