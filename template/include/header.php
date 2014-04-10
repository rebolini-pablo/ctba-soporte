<html>
  <head>
    <link rel="stylesheet" href="<?php echo Helper::asset('bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Helper::asset('font-awesome-4.0.3/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Helper::asset('css/main.css'); ?>">
    <script>var _base_url = "<?php echo Config::get('app', 'url'); ?>";</script>
    <script>var _user_type= "<?php echo (isset($_SESSION['user_type'])) ? $_SESSION['user_type'] : 0; ?>";</script>
  </head>
  <body>
  <div class="app app-messages"></div>