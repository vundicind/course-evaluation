courseeval
=================

A course evaluation system for USARB

Installation
--------------

### Yii

Initialize the application 

```sh
./init
```

Make sure you have `mcrypt` installed and enabled.

```sh
sudo apt-get install php5-mcrypt
sudo php5enmod mcrypt
sudo service apache2 restart
```
[Patch](http://blogyii.com/blog/undefined-method-csrfmetatags) the composer

```sh
bin/composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
```

Update all the dependencies

```sh
bin/composer install
```

Make all db migrations 

```sh
./yii migrate
```

### Apache

```sh
cd /etc/apache2/conf-available
ln -s /opt/courseeval/provision/apache2.conf courseeval.conf
a2enconf courseeval
service apache2 reload
```

You can test now enetering in the browser the address:

http://localhost/courseeval/

or 

http://localhost/courseeval-backend/
