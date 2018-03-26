<?php
include('session.php');
include('Cliente.php');
include('DAOCliente.php');
include('Impianto.php');
include('DAOImpianto.php');
include('Ambiente.php');
include('DAOAmbiente.php');
include('SensoreInstallato.php');
include('DAOSensoreInstallato.php');

$DAOCliente = new DAOCliente();
$cliente = $DAOCliente -> getFromId($id_cliente);
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "getImpianto") {
    if ($cliente) {
    $DAOImpianto = new DAOImpianto();
    $impianti = $DAOImpianto->getFromCliente($cliente);
    $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
      <tbody>";
    foreach ($impianti as $i) {
    $myString .=
    "<tr>
      <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"editAut('addImpianto',".$i->getId().",".$request->id.")\">".$i->getNome()."</td>
    </tr>";
    }
    $myString .=
    "</tbody>
    </table>
    </div>";
  }
} else if ($request->cod == "getAmbiente") {
  if ($cliente) {
    $DAOAmbiente = new DAOAmbiente();
    $DAOImpianto = new DAOImpianto();

    $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
    <tbody>";

    $impianti = $DAOImpianto->getFromCliente($cliente);
    foreach ($impianti as $i) {
      $ambienti = $DAOAmbiente->getFromImpianto($i->getId());
      foreach ($ambienti as $j) {
        $myString .=
        "<tr>
          <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"editAut('addAmbiente',".$j->getId().",".$request->id.")\">"."(".$i->getNome().") ".$j->getNome()."</td>
        </tr>";
      }
    }
    $myString .=
    "</tbody>
    </table>
    </div>";
  }
} else if ($request->cod == "getSensore") {
  if ($cliente) {
    $DAOImpianto = new DAOImpianto();
    $DAOSensoreInstallato = new DAOSensoreInstallato();
    $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
    <tbody>";
    $impianti = $DAOImpianto->getFromCliente($cliente);
    foreach ($impianti as $i) {
      $sensoriInstallati = $DAOSensoreInstallato->getFromImpianto($i->getId());
      foreach ($sensoriInstallati as $j) {
        $myString .=
        "<tr>
          <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"editAut('addSensore',".$j->getId().",".$request->id.")\">".$j->getNome()."</td>
        </tr>";
      }
    }
    $myString .=
    "</tbody>
    </table>
    </div>";
  }
}
}
echo($myString);
?>
