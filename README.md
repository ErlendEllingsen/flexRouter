# flexRouter
A small, lightweight php-router for clean, restful urls. Extremely easy to setup and configure.


###Installation
- require flexRouter.class.php
- create a new instance of flexRouter. 

###EXAMPLE
```
<?php
  require_once 'inc/flexRouter.class.php';
  $flexRouter = new flexRouter();

  if ($flexRouter->route('GET', '/login/:hello/pictures')) {
    echo 'GET was routed to login/:hello/pictures<br>';
    echo 'Picture ID: ' . $flexRouter->param(':hello');
  }  
  ?>
```
