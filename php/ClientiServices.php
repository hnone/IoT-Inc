<?php
include('session.php');
include('DAOImpianto.php');
include('Impianto.php');
include('DAOAmbiente.php');
include('Ambiente.php');
include('DAOSensoreInstallato.php');
include('SensoreInstallato.php');
$DAOImpianto = new DAOImpianto();
$DAOAmbiente = new DAOAmbiente();
$DAOSensoreInstallato = new DAOSensoreInstallato();

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "getAutorizzazioni") {
    $impianti = $DAOImpianto -> getFromIdCliente($request->id);
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
    </tr>";
    }
    $myString .=
    "</tbody>
    </table>
    </div>";

    $myString .=
    "<div class=\"mdl-card mdl-cell mdl-cell--4-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"ambienti\" style=\"width: 100%;\">
      <thead>
        <tr>
          <th class=\"mdl-data-table__cell--non-numeric\">Ambienti</th>
        </tr>
      </thead>
      <tbody>";
    foreach ($impianti as $i) {
      $ambienti = $DAOAmbiente -> getFromIdImpianto($i->getId());
      foreach ($ambienti as $j) {
      $myString .=
      "<tr>
        <td class=\"mdl-data-table__cell--non-numeric\">".$j->getNome()."</td>
      </tr>";
      }
    }
    $myString .=
    "</tbody>
    </table>
    </div>";

    $myString .=
    "<div class=\"mdl-card mdl-cell mdl-cell--4-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"sensori\" style=\"width: 100%;\">
      <thead>
        <tr>
          <th class=\"mdl-data-table__cell--non-numeric\">Sensori</th>
        </tr>
      </thead>
      <tbody>";
    foreach ($impianti as $i) {
      $sensori = $DAOSensoreInstallato -> getFromIdImpianto($i->getId());
      foreach ($sensori as $j) {
      $myString .=
      "<tr>
        <td class=\"mdl-data-table__cell--non-numeric\">".$j->getNome()."</td>
      </tr>";
      }
    }
    $myString .=
    "</tbody>
    </table>
    </div>";

  } 
  echo $myString;
}
?>
