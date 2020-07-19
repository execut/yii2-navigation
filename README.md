<p align="center">
    <h1 align="center">Yii2 navigation extension</h1>
</p>

Extension for managing everything related to navigation. Has widgets for display breadcrumbs with support microdata scheme, 
SEO tags, menus, title and text of the active page according to the given hierarchy. What unties all modules from each other
  necessary due to the possibility of dynamic customization.

For license information check the [LICENSE](LICENSE.md)-file.

English documentation is at [docs/guide/README.md](https://github.com/execut/yii2-navigation/blob/master/docs/guide/README.md).

Русская документация здесь [docs/guide-ru/README.md](https://github.com/execut/yii2-navigation/blob/master/docs/guide-ru/README.md).

[![Latest Stable Version](https://poser.pugx.org/execut/yii2-navigation/v/stable.png)](https://packagist.org/packages/execut/yii2-navigation)
[![Total Downloads](https://poser.pugx.org/execut/yii2-navigation/downloads.png)](https://packagist.org/packages/execut/yii2-navigation)
[![Build Status](https://travis-ci.com/execut/yii2-navigation.svg?branch=master)](https://travis-ci.com/yiisoft/execut/yii2-navigation)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require execut/yii2-navigation
```

or add

```
"execut/yii2-navigation": "dev-master"
```

to the require section of your `composer.json` file.

Usage
----

For example, the following
single line of code in a view file would render a text of active page:

```php
<?= \execut\navigation\widgets\Text::widget() ?>
```
