<html>
<link rel="stylesheet" href="css/choose.css">
<body>
  <div class="box"  ng-cloak ng-controller="ChooseCtrl">
    <div class="header">
      <div class="welcome">
        <h3 id="welcome">Benvenuto</h3>
        <h3 id="welcome_name"><?php echo $login_session; ?></h3>
      </div>
    </div>
    <div class="container">
      <div class="claimHead col-md-12">
        <div id="stepsContainer">
          <?php echo $htmlString ?>
          </div>
        </div>
      </div>
  </div>
</body>
</html>
