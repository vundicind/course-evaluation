course-evaluation
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
php5enmod mcrypt
```

### Apache

```sh
cd /etc/apache2/conf-available
ln -s /home/vundicind/course-evaluation/provision/apache2.conf course-evaluation.conf
a2enconf course-evaluation
service apache2 reload
```
