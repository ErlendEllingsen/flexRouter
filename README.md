# flexRouter
A small, lightweight php-router for clean, restful urls. Extremely easy to setup and configure.
Supports parameters, wildcard urls.

I might add IIS and Nginx-guides/examples later.

[![Build Status](https://travis-ci.org/ErlendEllingsen/flexRouter.svg)](https://travis-ci.org/ErlendEllingsen/flexRouter/)

###Installation
1. require flexRouter.class.php
2. create a new instance of flexRouter. 
3. Add .htaccess-file

**NB:** Apache-module mod_rewrite must be enabled.

###EXAMPLE
###HTACCESS
```htaccess
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^?]*)$ index.php?path=$1 [NC,L,QSA]
```

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
