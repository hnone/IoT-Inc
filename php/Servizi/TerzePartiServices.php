<?php
include '../session.php';
include '../DAO/DAOImpianto.php';
include '../DAO/DAOAmbiente.php';
include '../DAO/DAOSensoreInstallato.php';
include '../DAO/DAOTerzaParte.php';
include '../Modelli/Impianto.php';
include '../Modelli/Ambiente.php';
include '../Modelli/SensoreInstallato.php';
include '../Modelli/TerzaParte.php';

$DAOTerzaParte = new DAOTerzaParte();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if ($request->cod == "add") {
        $DAOTerzaParte -> insert(new TerzaParte($request->nome, $request->cognome, $request->email, $request->tempo, $id_cliente));
    } elseif ($request->cod == "edit") {
        $DAOTerzaParte -> update($request->id, $request->nome, $request->cognome, $request->email, $request->tempo);
    } elseif ($request->cod == "remove") {
        $DAOTerzaParte -> delete($request->id);
    } elseif ($request->cod == "getImpianto") {
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
  } elseif($request->cod == "getAll") {
    $myString = "";
    $terzeParti = $DAOTerzaParte -> getFromIdCliente($id_cliente);
    foreach ($terzeParti as $i) {
        $toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
        $myString .=
      "<tr ng-click=\"terzePartiList.editDialog(\$event,".$toPass2.")\">
        <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
        <td class=\"mdl-data-table__cell--non-numeric\">".$i->getCognome()."</td>
        <td class=\"mdl-data-table__cell--non-numeric\">".$i->getEmail()."</td>
        <td class=\"mdl-data-table__cell\" style=\"text-align:  center;\">".$i->getTempo()."</td>
      </tr>";
    }
  } elseif ($request->cod == "getAmbiente") {
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
    } elseif ($request->cod == "getSensore") {
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
