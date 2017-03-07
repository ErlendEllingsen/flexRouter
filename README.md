<img alt="flexRouter logo" src="https://i.imgur.com/N0HECca.png" width="400px;"> 

[![Build Status](https://travis-ci.org/ErlendEllingsen/flexRouter.svg)](https://travis-ci.org/ErlendEllingsen/flexRouter/) [![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)

# flexRouter
An extremely *small* and *lightweight* PHP-router for clean, RESTful urls. Extremely easy to setup and requires no configuration. Just plain dead simple routing.

Supports parameters, different HTTP-methods and wildcard urls.


## Installation
####Composer
```composer require erlendellingsen/flex-router```


1. require flexRouter.class.php
2. create a new instance of flexRouter. 
3. Add .htaccess-file


### Setup
URL-rewrite must be enabled on the target server. This guide consists of an example on how to set it up on Apache-servers. **If you do have IIS, Nginx or other examples, then <u>please contribute!</u>**

#### Apache
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

#### Non-Apache
You *somehow* have to enable rewriting of urls in your webserver/directory to point all requests to `index.php?path=x`. If you have somewhat idea how, but need assistance then don't hesistate to **reach out**. 

If you do have an example for other webservers then please consider getting in touch. (Open an issue, a fork, or just email me). Contributions are **very much** appreciated ☺️



## Usage
The example beneath demonstrates how to easy setup *flexRouter*. 


####PHP

```php
<?php
      require_once 'inc/flexRouter.class.php';
      $flexRouter = new flexRouter();
      
      //Example with parameters 
      if ($flexRouter->route('GET', '/login/:hello/pictures')) {
            echo 'GET was routed to login/:hello/pictures<br>';
            echo 'Picture ID: ' . $flexRouter->param(':hello');
      }  
      
      //Wildcard-example
      if ($flexRouter->route('GET', '/i/like/horses*')) {
            echo 'GET was routed to /i/like/horses*<br>';
      }  
      
?>
```

## Contribution
Want to contribute? Lovely! Contributions are very much appreciated. There are a ton of things to do in this project, but I don't have the time do to it. (Atleast not all).

**Areas where contribution is deeply needed**

* Writing documentation (Get in touch if you need help!)
* Making a better readme
* Creating tests
* Improving exception-handling
* Better way to handle *GET/POST* (Support DELETE, PUT, etc).

And probably *much much more*.


## License 
**MIT** Copyright Erlend Ellingsen 2017. See [LICENSE](https://github.com/ErlendEllingsen/flexRouter/blob/master/LICENSE).
