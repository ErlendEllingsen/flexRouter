<img alt="flexRouter logo" src="https://i.imgur.com/N0HECca.png" width="400px;"> 

[![Build Status](https://travis-ci.org/ErlendEllingsen/flexRouter.svg)](https://travis-ci.org/ErlendEllingsen/flexRouter/)
[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)

# flexRouter

An extremely *small* and *lightweight* PHP-router for clean, RESTful urls. Extremely easy to setup and requires no
configuration. Just plain dead simple routing.

Supports parameters, different HTTP-methods and wildcard urls.

## What's Changed

As the new maintainer I tried to implement a better more robust architecture without going away from the initial goal
of the router which was to work off of if based control structures.

This may change in the future as the project evolves. Below is the reworked example of how I envision you using the
router in its new, unit tested, form.

## Installation

    composer require erlendellingsen/flex-router

## Setup

URL-rewrite must be enabled on the target server. This guide consists of an example on how to set it up on
Apache-servers. **If you do have IIS, Nginx or other examples, then <u>please contribute!</u>**

## Apache

**Configuration**

* Apache-module `mod_rewrite` **must** be enabled.
* Required Apache-vhost/Directory-setting ```AllowOverride all```

**.htaccess-file**

```htaccess
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^?]*)$ index.php?path=$1 [NC,L,QSA]
```

## Non-Apache

You *somehow* have to enable rewriting of urls in your web server/directory to point all requests to `index.php?path=x`.
If you have somewhat idea how, but need assistance then don't hesitate to **reach out**. 

If you do have an example for other web servers then please consider getting in touch. (Open an issue, a fork, or just
email me). Contributions are **very much** appreciated ☺️

## Usage

The example beneath demonstrates how to setup *flexRouter*.

```php
<?php

// Load the namespaces
use FlexRouter\FlexRouter;
use FlexRouter\Utilities\FlexResolver;

// Load in composer's autoloader
require_once 'vendor/autoload.php';

// Create a new router instance
$router = new FlexRouter();

/* Register your routes

Register Method        | Request Method | Route           | Route Id                           */
$router->registerRoute('GET',           '/',              'homepage'); // Can pass single method
$router->registerRoute(['GET', 'POST'], '/test',          'test');     // Or an array of methods
$router->registerRoute('GET',           '/test/:id/post', 'param');    // You can create URL params
$router->registerRoute('GET',           '/asdf*',         'wildcard'); // Or Wildcard Params

// Create your resolver
$requestMethod = $_SERVER['REQUEST_METHOD']; // Can be attained from either globals or request object
$requestUri    = $_SERVER['REQUEST_URI'];    // Can be attained from either globals or request object
$resolver      = new FlexResolver($requestMethod, $requestUri, $router);

// Start resolving your routes in whatever way you would like,
if ($resolver->resolve('homepage')) {
    echo 'The homepage route was found';

    return;
}

if ($resolver->resolve('test')) {
    echo 'The nested test route was found';

    return;
}

if ($resolver->resolve('param')) {
    echo "The param test route was found\r\n";
    echo $resolver->access()->params('url', 'id');

    return;
}

if ($resolver->resolve('wildcard')) {
    echo 'The wildcard test route was found';

    return;
}

// This is the 404 catch all
$resolver->notFound(function () {
    echo 'Nothing found';

    return;
});
```

## Contribution

Want to contribute? Lovely! Contributions are very much appreciated. There are a ton of things to do in this project,
but I don't have the time do to it. (At least not all).

**Areas where contribution is deeply needed**

* Writing documentation (Get in touch if you need help!)
* Making a better readme
* Creating tests
* Improving exception-handling
* Better way to handle *GET/POST* (Support DELETE, PUT, etc).

And probably *much much more*.

## License 

**MIT** Copyright Erlend Ellingsen 2017. See [LICENSE](https://github.com/ErlendEllingsen/flexRouter/blob/master/LICENSE).
