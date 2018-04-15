<?php 'php/login.php' ?>
<!DOCTYPE html>
<html lang="it" >
<head>
  <meta charset="UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - IoT Inc.</title>

  <meta name="msapplication-tap-highlight" content="no">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="application-name" content="IoT Inc.">
  <link rel="icon" sizes="192x192" href="images/touch/chrome-touch-icon-192x192.png">

  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="IoT Inc.">
  <link rel="apple-touch-icon" href="images/touch/apple-touch-icon.png">

  <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
  <meta name="msapplication-TileColor" content="#2F3BA2">

  <meta name="theme-color" content="#2F3BA2">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel="stylesheet" href="css/index.css">

</head>
<body>
  <div class="login">
  <img src="logo.png" id="logo">
  <form action = "" method = "post">
  <input type="text" name="username" placeholder="Username" required="required" />
  <input type="password" name="password" placeholder="Password" required="required" />
  <input id="login" type="submit" name = "login" class="btn btn-primary btn-block btn-large" value = "Login"/>
  </form>
  <div id="result"><?php if (isset($error)) {
    echo $error;
} ?></div>
</div>
</body>
</html>
