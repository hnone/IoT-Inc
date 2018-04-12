<?php
include '../session.php';
include '../DAO/DAOCliente.php';
include '../DAO/DAOImpianto.php';
include '../DAO/DAOSensoreInstallato.php';
include '../Modelli/Impianto.php';
include '../Modelli/DAOAmbiente.php';
include '../Modelli/Ambiente.php';
include '../Modelli/SensoreInstallato.php';
include '../Modelli/Cliente.php';

$DAOCliente = new DAOCliente();
$DAOImpianto = new DAOImpianto();
$DAOAmbiente = new DAOAmbiente();
$DAOSensoreInstallato = new DAOSensoreInstallato();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if ($request->cod == "add") {
        $DAOCliente -> insert(new Cliente($request->nome, $request->cognome, $request->partitaIva, $request->email, $request->password));
    } elseif ($request->cod == "edit") {
        $toUpdate = new Cliente($request->nome, $request->cognome, $request->partitaIva, $request->email, $request->password);
        $toUpdate -> setId($request->id);
        $DAOCliente -> update($toUpdate);
    } elseif ($request->cod == "remove") {
        $DAOCliente -> delete($request->id);
    } elseif ($request->cod == "getAll") {
        $clienti = $DAOCliente -> getAll();
        $myString = "";
        foreach ($clienti as $i) {
            $toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
            if ($i->getId() == $_SESSION['id_cliente']) {
            } else {
                $myString .=
        "<tr ng-click=\"clientiList.editDialog(\$event,".$toPass2.")\">
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getCognome()."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getEmail()."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getPartitaIva()."</td>
        </tr>";
            }
        }
    } elseif ($request->cod == "getAutorizzazioni") {
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
