<?php

  include 'vendor/autoload.php';
  include 'routes.php';

  /**
   *
   */
   $route = (isset($_GET['route'])) ?
    $_GET['route'] : '/';
    
   Router::execute($route);