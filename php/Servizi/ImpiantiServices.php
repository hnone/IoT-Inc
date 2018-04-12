<?php
include '../session.php';
include '../DAO/DAOCliente.php';
include '../DAO/DAOImpianto.php';
include '../DAO/DAOAmbiente.php';
include '../DAO/DAOSensore.php';
include '../DAO/DAOSensoreInstallato.php';
include '../Modelli/Cliente.php';
include '../Modelli/Impianto.php';
include '../Modelli/Ambiente.php';
include '../Modelli/Sensore.php';
include '../Modelli/SensoreInstallato.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $myString = "";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $DAOAmbiente = new DAOAmbiente();
    if ($request->cod == "getAutorizzazioni") {
        //getAmbienti(impianto)
        $ambienti = $DAOAmbiente -> getFromIdImpianto($request->id);
        $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--6-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"ambienti\" style=\"width: 100%;\">
      <thead>
        <tr>
          <th class=\"mdl-data-table__cell--non-numeric\">Ambienti</th>
        </tr>
      </thead>
      <tbody>";
        foreach ($ambienti as $i) {
            $myString .=
    "<tr ng-click=\"editImpianto('Ambiente',".$i->getId().")\">
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
    </tr>";
        }
        $myString .=
    "</tbody>
    </table>
    <button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"add\" data-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"add('addAmbiente',".$request->id.")\">
        <i class=\"material-icons\">add</i>
    </button>
    </div>";
        //getSensoriInstallati(impianto)
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        $DAOAmbiente = new DAOAmbiente();
        $sensori = $DAOSensoreInstallato -> getFromIdImpianto($request->id);
        $myString .=
    "<div class=\"mdl-card mdl-cell mdl-cell--6-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"sensori\" style=\"width: 100%;\">
      <thead>
        <tr>
          <th class=\"mdl-data-table__cell--non-numeric\">Sensori installati</th>
        </tr>
      </thead>
      <tbody>";

        foreach ($sensori as $i) {
            if (is_null($i->getIdAmbiente())) {
                $nomeAmbiente = "Nessuno";
            } else {
                $ambiente = $DAOAmbiente -> getFromId($i->getIdAmbiente());
                $nomeAmbiente = $ambiente->getNome();
            }
            $myString .=
    "<tr ng-click=\"editImpianto('Sensore',".$i->getId().")\">
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getId().": (".$nomeAmbiente.") ".$i->getNome()."</td>
    </tr>";
        }
        $myString .=
    "</tbody>
    </table>
    <button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"add\" data-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"add('addSensore',".$request->id.")\">
        <i class=\"material-icons\">add</i>
    </button>
    </div>";
    } elseif ($request->cod == "getNomeImpianto") {
        //Non necessario passando l'oggetto Impianto
        $DAOImpianto = new DAOImpianto();
        $impianto = $DAOImpianto -> getFromId($request->id);
        $myString = $impianto->getNome();
    } elseif ($request->cod == "getNomeCliente") {
        //getProprietario(impianto) -> Cliente
        $DAOCliente = new DAOCliente();
        if (is_null($request->id)) {
            $myString = "Nessuno";
        } else {
            $cliente = $DAOCliente -> getFromId($request->id);
            $myString = $cliente->getNome()." ".$cliente->getCognome();
        }
    } elseif ($request->cod == "getNomeAmbiente") {
        //Non necessario passando l'oggetto Ambiente
        $DAOAmbiente = new DAOAmbiente();
        if (is_null($request->id)) {
            $myString = "Nessuno";
        } else {
            $ambiente = $DAOAmbiente -> getFromId($request->id);
            $myString = $ambiente->getNome();
        }
    } elseif ($request->cod == "getSensoreInstallato") {
        //Non necessario passando l'oggetto SensoreInstallato
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        $sensoreInstallato = $DAOSensoreInstallato -> getFromId($request->id);
        $myString = json_encode($sensoreInstallato);
    } elseif ($request->cod == "getNomeSensore") {
        //Non necessario passando l'oggetto Sensore
        $DAOSensore = new DAOSensore();
        $sensore = $DAOSensore-> getFromId($request->id);
        $myString = $sensore->getNome();
    } elseif ($request->cod == "deleteAmbiente") {
        //rimuoviAmbiente(ambiente)
        echo "deleteAmbiente";
        $DAOAmbiente = new DAOAmbiente();
        $DAOAmbiente -> delete($request->id);
    } elseif ($request->cod == "deleteSensore") {
        //rimuoviSensore(sensore)
        echo "deleteSensore";
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        $DAOSensoreInstallato -> delete($request->id);
    } elseif ($request->cod == "editAmbiente") {
        //aggiornaAmbiente(ambiente)
        echo "editAmbiente";
        $DAOAmbiente = new DAOAmbiente();
        $toUpdate = new Ambiente($request->nomeAmbiente, $request->idImpianto);
        $toUpdate -> setId($request->id);
        $DAOAmbiente -> update($toUpdate);
    } elseif ($request->cod == "editSensore") {
        //aggiornaSensoreInstallato(sensoreInstallato)
        echo "editSensore";
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        if ($request->idAmbiente == -1) {
            $toUpdate = new SensoreInstallato($request->nome, $request->idSensore, $request->idImpianto, null);
        } else {
            $toUpdate = new SensoreInstallato($request->nome, $request->idSensore, $request->idImpianto, $request->idAmbiente);
        }
        $toUpdate -> setId($request->id);
        $DAOSensoreInstallato -> update($toUpdate);
    } elseif ($request->cod == "addAmbiente") {
        //aggiungiAmbiente(ambiente)
        echo "addAmbiente";
        $DAOAmbiente = new DAOAmbiente();
        $DAOAmbiente -> insert(new Ambiente($request->nomeAmbiente, $request->idImpianto));
    } elseif ($request->cod == "addSensore") {
        //aggiungiSensore(sensoreInstallato)
        echo "addSensore";
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        if ($request->idAmbiente == -1) {
            $DAOSensoreInstallato -> insert(new SensoreInstallato($request->nome, $request->idSensore, $request->idImpianto, null));
        } else {
            $DAOSensoreInstallato -> insert(new SensoreInstallato($request->nome, $request->idSensore, $request->idImpianto, $request->idAmbiente));
        }
    } elseif ($request->cod == "getCliente") {
        //torna la lista di clienti (getAll da ClientiServices)
        $DAOCliente = new DAOCliente();
        $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
    <tbody>";
        $myString .=
    "<tr>
      <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"addCliente(-1,'Nessuno')\">Nessuno</td>
    </tr>";
        $clienti = $DAOCliente->getAll();
        foreach ($clienti as $j) {
            if ($j->getId() != $_SESSION['id_cliente']) {
                $myString .=
        "<tr>
          <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"addCliente(".$j->getId().",'".$j->getNome()." ".$j->getCognome()."')\">".$j->getNome()." ".$j->getCognome()."</td>
        </tr>";
            }
        }
        $myString .=
  "</tbody>
  </table>
  </div>";
    } elseif ($request->cod == "getAmbiente") {
        //getAmbienti(impianto)
        $DAOAmbiente = new DAOAmbiente();
        $myString =
      "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
      <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
      <tbody>";
        $myString .=
      "<tr>
        <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"setAmbiente(-1,'Nessuno')\">Nessuno</td>
      </tr>";
        $ambienti = $DAOAmbiente->getFromIdImpianto($request->id);
        foreach ($ambienti as $j) {
            $myString .=
          "<tr>
            <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"setAmbiente(".$j->getId().",'".$j->getNome()."')\">".$j->getNome()."</td>
          </tr>";
        }
        $myString .=
    "</tbody>
    </table>
    </div>";
    } elseif ($request->cod == "getSensore") {
        //torna la lista di sensori (getAll da SensoreServices)
        $DAOSensore = new DAOSensore();
        $myString =
      "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
      <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
      <tbody>";
        $sensori = $DAOSensore->getAll();
        foreach ($sensori as $j) {
            $myString .=
          "<tr>
            <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"setSensore(".$j->getId().",'".$j->getNome()."')\">".$j->getNome()."</td>
          </tr>";
        }
        $myString .=
    "</tbody>
    </table>
    </div>";
    }
    echo $myString;
}
