<?php
include('session.php');
include('Impianto.php');
include('DAOImpianto.php');
include('Ambiente.php');
include('DAOAmbiente.php');
include('SensoreInstallato.php');
include('DAOSensoreInstallato.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "getImpianto") {
    $DAOImpianto = new DAOImpianto();
    $impianti = $DAOImpianto->getFromIdCliente($id_cliente);
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
} else if ($request->cod == "getAmbiente") {
    $DAOAmbiente = new DAOAmbiente();
    $DAOImpianto = new DAOImpianto();
    $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
    <tbody>";

    $impianti = $DAOImpianto->getFromIdCliente($id_cliente);
    foreach ($impianti as $i) {
      $ambienti = $DAOAmbiente->getFromIdImpianto($i->getId());
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
} else if ($request->cod == "getSensore") {
    $DAOImpianto = new DAOImpianto();
    $DAOSensoreInstallato = new DAOSensoreInstallato();
    $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
    <tbody>";
    $impianti = $DAOImpianto->getFromIdCliente($id_cliente);
    foreach ($impianti as $i) {
      $sensoriInstallati = $DAOSensoreInstallato->getFromIdImpianto($i->getId());
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
echo($myString);
?>
