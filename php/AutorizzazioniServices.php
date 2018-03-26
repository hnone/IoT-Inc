<?php
include('session.php');
include('TerzaParte.php');
include('DAOAutorizzazione.php');
include('Impianto.php');
include('Ambiente.php');
include('SensoreInstallato.php');
$DAOAutorizzazione = new DAOAutorizzazione();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "getAutorizzazioni") {
    $impianti = $DAOAutorizzazione -> getImpianti($request->id);
    $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--4-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
      <thead>
        <tr>
          <th class=\"mdl-data-table__cell--non-numeric\">Impianti</th>
        </tr>
      </thead>
      <tbody>";
    foreach ($impianti as $i) {
    $myString .=
    "<tr>
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
      <td><button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"delete\" ata-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"editAut('deleteImpianto',".$i->getId().",".$request->id.")\">
          <i class=\"material-icons\">delete</i>
      </button></td>
    </tr>";
    }
    $myString .=
    "</tbody>
    </table>
    <button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"add\" data-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"addAut('addImpianto',".$request->id.")\">
        <i class=\"material-icons\">add</i>
    </button>
    </div>";

    $ambienti = $DAOAutorizzazione -> getAmbienti($request->id);
    $myString .=
    "<div class=\"mdl-card mdl-cell mdl-cell--4-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"ambienti\" style=\"width: 100%;\">
      <thead>
        <tr>
          <th class=\"mdl-data-table__cell--non-numeric\">Ambienti</th>
        </tr>
      </thead>
      <tbody>";
    foreach ($ambienti as $i) {
    $myString .=
    "<tr>
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
      <td><button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"delete\" ata-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"editAut('deleteAmbiente',".$i->getId().",".$request->id.")\">
          <i class=\"material-icons\">delete</i>
      </button></td>
    </tr>";
    }
    $myString .=
    "</tbody>
    </table>
    <button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"add\" data-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"addAut('addAmbiente',".$request->id.")\">
        <i class=\"material-icons\">add</i>
    </button>
    </div>";

    $sensori = $DAOAutorizzazione -> getSensoriInstallati($request->id);
    $myString .=
    "<div class=\"mdl-card mdl-cell mdl-cell--4-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"sensori\" style=\"width: 100%;\">
      <thead>
        <tr>
          <th class=\"mdl-data-table__cell--non-numeric\">Sensori</th>
        </tr>
      </thead>
      <tbody>";
    foreach ($sensori as $i) {
    $myString .=
    "<tr>
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
      <td><button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"delete\" ata-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"editAut('deleteSensore',".$i->getId().",".$request->id.")\">
          <i class=\"material-icons\">delete</i>
      </button></td>
    </tr>";
    }
    $myString .=
    "</tbody>
    </table>
    <button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"add\" data-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"addAut('addSensore',".$request->id.")\">
        <i class=\"material-icons\">add</i>
    </button>
    </div>";

    echo $myString;
  }
  else if ($request->cod == "deleteImpianto") {
    echo "deleteImpianto";
    echo $request->aut;
    echo $request->id;
    $DAOAutorizzazione -> removeImpianto($request->id, $request->aut);
  } else if ($request->cod == "deleteAmbiente") {
    echo "deleteAmbiente";
    echo $request->aut;
    echo $request->id;
    $DAOAutorizzazione -> removeAmbiente($request->id, $request->aut);
  } else if ($request->cod == "deleteSensore") {
    echo "deleteSensore";
    echo $request->aut;
    echo $request->id;
    $DAOAutorizzazione -> removeSensoreInstallato($request->id, $request->aut);
  } else if ($request->cod == "addImpianto") {
    echo "addImpianto";
    echo $request->aut;
    echo $request->id;
    $DAOAutorizzazione -> insertImpianto($request->id, $request->aut);
  } else if ($request->cod == "addAmbiente") {
    echo "addAmbiente";
    echo $request->aut;
    echo $request->id;
    $DAOAutorizzazione -> insertAmbiente($request->id, $request->aut);
  } else if ($request->cod == "addSensore") {
    echo "addSensore";
    echo $request->aut;
    echo $request->id;
    $DAOAutorizzazione -> insertSensoreInstallato($request->id, $request->aut);
  }
}
?>
