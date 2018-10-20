Extention for the work with csv files
=====================================
This extention can help You with read & edit the csv files

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Because of dependences You need to setup `"minimum-stability": "dev"` in Your `composer.json` file.

Either run

```
php composer.phar require --prefer-dist gurikin/yii2-csvwork "*"
```

or add

```
"gurikin/yii2-csvwork": "*"
```

to the require section of your `composer.json` file.

Setup
-----

This extension don't need in additional settings, but for the review of needed setups for the dependencies, please pass to the:

```
https://github.com/kartik-v
```

Usage
-----

Once the extension is installed, simply use it as the module on

```
http://SERVER_NAME/csvwork/work/index
```

or You can use this extension by using main model class

```php
\gurikin\csvwork\src\models\CSVModel
```
see the WorkController class for example.

IT IS IMPORTANT!!!

Main source file "source.csv" put on the
```
\gurikin\csvwork\src\source\source.csv
```
You can fill it as you want (with csv rules) but I strongly suggest to use as the delimiter between the columns ";" char.
If you want to change content of this file - you need to create new views and forms and use it instead the default.
