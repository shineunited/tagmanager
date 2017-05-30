Shine United - Tag Manager
==========================

A basic PHP abstraction for Google Tag Manager container and datalayer.

[![Latest Stable Version](https://img.shields.io/packagist/v/shineunited/tagmanager.svg?style=flat-square)](https://packagist.org/packages/shineunited/tagmanager)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/shineunited/tagmanager/master.svg?style=flat-square)](https://travis-ci.org/shineunited/tagmanager)

Installation
------------

The recommended way to install Tag Manager is through
[Composer](http://getcomposer.org).

#### Install Composer
```bash
$ curl -sS https://getcomposer.org/installer | php
```

#### Add package to composer.json
```bash
$ composer require shineunited/tagmanager
```

#### Update dependencies
```bash
$ composer.phar update
```

#### Include autoloader
```php
include(__DIR__ . '/../vendor/autoload.php');
```


Usage
-----

#### Silex

To use Tag Manager with Silex, register the service provider
```php
use ShineUnited\TagManager\Silex\TagManagerServiceProvider();

$app->register(new TagManagerServiceProvider(), [
	'gtm.options' => [
		'id'      => 'GTM-XXXX', //gtm container id (required)
		'persist' => true,       //persist datalayer in session if true (optional, defaults to false)
		'varname' => 'gtm'       //session varname (optional, defaults to 'gtm')
	]
]);
```

Adding messages to the datalayer
```php
$app['gtm.datalayer']->push([
	'event'     => 'gtm.eventName',
	'eventData' => [
		// event data goes here
	]
]);
```

#### Twig

The extension adds the 'gtm()' function to the Twig environment. Note: the silex service provider will automatically install the twig extension if twig is present.

```html
<html>
<body>

	...
	{{ gtm() }}
</body>
</html>
```
