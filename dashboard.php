<?php
include 'php/session.php';
?>
<html lang="it" ng-app="MyApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard - IoT Inc.</title>

    <meta name="msapplication-tap-highlight" content="no">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="IoT Inc.">
    <link rel="icon" sizes="192x192" href="images/touch/chrome-touch-icon-192x192.png">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Iot Inc.">
    <link rel="apple-touch-icon" href="images/touch/apple-touch-icon.png">

    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#38405f">

    <meta name="theme-color" content="#38405f">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script>document.write('<base href="' + document.location + '" />');</script>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
    <link rel="stylesheet" href = "css/material.css">
    <script src = "/js/material.js"></script>
    <script src = "https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.9/angular-sanitize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-messages.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.1/nv.d3.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.1/nv.d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.9/angular-nvd3.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css"/>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.1.8/angular-material.js"></script>

    <link rel="stylesheet" href="css/dash.css">
    <script src = "app.js"></script>
    <script src = "/js/chooseCtrl.js"></script>
    <script src = "/js/clientiCtrl.js"></script>
    <script src = "/js/homeCtrl.js"></script>
    <script src = "/js/impiantiCtrl.js"></script>
    <script src = "/js/rilevazioniCtrl.js"></script>
    <script src = "/js/sensoriCtrl.js"></script>
    <script src = "/js/soglieCtrl.js"></script>
    <script src = "/js/terzePartiCtrl.js"></script>

  </head>
  <body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base" ng-controller="MainCtrl">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header mdl-layout--fixed-header mdl-color--primary">
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
          <?php if (!$_SESSION['isAmministratore']) {?>
          <a href="#/choose">
          <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-shadow--4dp" id="back">
            <i class="material-icons" role="presentation">business</i>
            <span class="visuallyhidden">Cambia Impianto</span>
          </button>
          </a>
          <a href="#/home" style="display:{{both2()}};" class="mdl-layout__tab" ng-class="{isactive: $route.current.map == 'home'}">{{both()}}</a>
          <a href="#/soglie" style="display:{{both3()}};" class="mdl-layout__tab gone" ng-class="{isactive: $route.current.map == 'soglie'}">{{both1()}}</a>
          <a href="#/terzeParti" class="mdl-layout__tab gone" ng-class="{isactive: $route.current.map == 'terzeParti'}">Terze Parti</a>
          <?php } else {?>
          <a href="#/clienti" class="mdl-layout__tab" ng-class="{isactive: $route.current.map == 'clienti'}">Clienti</a>
          <a href="#/impianti" class="mdl-layout__tab" ng-class="{isactive: $route.current.map == 'impianti'}">Impianti</a>
          <a href="#/sensori" class="mdl-layout__tab" ng-class="{isactive: $route.current.map == 'sensori'}">Sensori</a>
          <?php } ?>
          <form action = "/php/logout.php" method = "post" name="logout">
          <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-shadow--4dp" id="logout">
            <i class="material-icons" role="presentation">exit_to_app</i>
            <span class="visuallyhidden">Logout</span>
          </button>
        </form>
        </a>
        </div>
      </header>
      <div class="mdl-layout__drawer mine" id="drawer">
        <span class="mdl-layout-title">Title</span>
        <nav class="mdl-navigation">
          <a href="#/home" style="display:{{both2()}};" class="mdl-navigation__link" ng-class="{isactive: $route.current.map == 'home'}">{{both()}}</a>
          <a href="#/soglie" style="display:{{both3()}};" class="mdl-navigation__link" ng-class="{isactive: $route.current.map == 'soglie'}">{{both1()}}</a>
          <a href="#/terzeParti" class="mdl-navigation__link" ng-class="{isactive: $route.current.map == 'terzeParti'}">Terze Parti</a>
          <?php } else {?>
          <a href="#/clienti" class="mdl-navigation__link" ng-class="{isactive: $route.current.map == 'clienti'}">Clienti</a>
          <a href="#/impianti" class="mdl-navigation__link" ng-class="{isactive: $route.current.map == 'impianti'}">Impianti</a>
          <a href="#/sensori" class="mdl-navigation__link" ng-class="{isactive: $route.current.map == 'sensori'}">Sensori</a>
          <?php } ?>
          <a href="/php/logout.php" class="mdl-navigation__link">Logout</a>
        </nav>
      </div>
      <div id="we" ng-view></div>
      <footer class="mdl-mega-footer mdl-layout--fixed-header">
        <md-toolbar class="md-scroll-shrink">
        <div class="mdl-mega-footer--bottom-section">
          <div id="footerText">© Copyright 2018 - IoT Inc. - P.I. 01234567890</div>
        </div>
      </footer>
    </div>
  </body>
</html>
