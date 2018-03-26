<?php
include('php/session.php');
include('php/DAOCliente.php');
include('php/Cliente.php');
include('php/DAOImpianto.php');
include('php/Impianto.php');
$DAOCliente = new DAOCliente();
$cliente = $DAOCliente -> getFromId($id_cliente);
if ($cliente) {
  $DAOImpianto = new DAOImpianto();
  $impianti = $DAOImpianto->getFromCliente($cliente);
  $htmlString = "";
  foreach ($impianti as $i) {
    $htmlString .=
   //"<a href='dashboard.php?id=".$i->getId()."''>
   //"<a href='dashboard.php?id=".$i->getId()."''>
    "<div class=\"col-md-4 stepsBox\" ng-click=\"chooseImpianto(\$event,".$i->getId().")\">
      <div class=\"claimSteps\" id=\"stepOne\">
        <p class=\"claimStepTitle\">".$i->getNome()."</p>
        <p class=\"claimStepText\">".$i->getTipo()."</p>
      </div>
    </div>";
  //  </a>";
  }
}
?>

  <link rel="stylesheet" href="css/impianti.css">
  <style>
  .mdl-mega-footer {
    background-color: transparent !important;
  }
  </style>
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
