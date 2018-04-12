<?php
include '../session.php';
include '../Modelli/SensoreInstallato.php';
include '../DAO/DAOSogliaAmbiente.php';
include '../DAO/DAOSogliaSensore.php';
include '../DAO/DAOAmbiente.php';
include '../DAO/DAOSensoreInstallato.php';
include '../DAO/DAOSensore.php';
include '../Modelli/SogliaAmbiente.php';
include '../Modelli/SogliaSensore.php';
include '../Modelli/Ambiente.php';
include '../Modelli/Sensore.php';

$DAOSogliaSensore = new DAOSogliaSensore();
$DAOSogliaAmbiente = new DAOSogliaAmbiente();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if ($request->cod == "addSogliaSensore") {
        if ($request->maggMin == "maggiore") {
            $DAOSogliaSensore -> insert(new SogliaSensore($request->nome, $request->valore, null, $request->idSensore));
        } else {
            $DAOSogliaSensore -> insert(new SogliaSensore($request->nome, null, $request->valore, $request->idSensore));
        }
    } elseif ($request->cod == "addSogliaAmbiente") {
        if ($request->maggMin == "maggiore") {
            $DAOSogliaAmbiente -> insert(new SogliaAmbiente($request->nome, $request->valore, null, $request->tipo, $request->idAmbiente));
        } else {
            $DAOSogliaAmbiente -> insert(new SogliaAmbiente($request->nome, null, $request->valore, $request->tipo, $request->idAmbiente));
        }
    } elseif ($request->cod == "editSogliaSensore") {
        if ($request->maggMin == "maggiore") {
            $toUpdate = new SogliaSensore($request->nome, $request->valore, null, $request->idSensore);
        } else {
            $toUpdate = new SogliaSensore($request->nome, null, $request->valore, $request->idSensore);
        }
        $toUpdate -> setId($request->id);
        $DAOSogliaSensore -> update($toUpdate);
    } elseif ($request->cod == "editSogliaAmbiente") {
        if ($request->maggMin == "maggiore") {
            $toUpdate = new SogliaAmbiente($request->nome, $request->valore, null, $request->tipo, $request->idAmbiente);
        } else {
            $toUpdate = new SogliaAmbiente($request->nome, null, $request->valore, $request->tipo, $request->idAmbiente);
        }
        $toUpdate -> setId($request->id);
        $DAOSogliaAmbiente -> update($toUpdate);
    } elseif ($request->cod == "removeSogliaSensore") {
        $DAOSogliaSensore -> delete($request->id);
    } elseif ($request->cod == "removeSogliaAmbiente") {
        $DAOSogliaAmbiente -> delete($request->id);
    } elseif ($request->cod == "getSensore") {
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        $myString =
    "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
    <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
    <tbody>";
        //getSensoriInstallati(impianto) IMPIANTOSERVICES
        $sensoriInstallati = $DAOSensoreInstallato->getFromIdImpianto($request->id);
        foreach ($sensoriInstallati as $j) {
            $myString .=
        "<tr>
          <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"addSoglia('addSensore',".$j->getId().",'".$j->getNome()."')\">".$j->getNome()."</td>
        </tr>";
        }
        //}
        $myString .=
    "</tbody>
    </table>
    </div>";
    } elseif ($request->cod == "getAmbiente") {
        $DAOAmbiente = new DAOAmbiente();
        $myString =
      "<div class=\"mdl-card mdl-cell mdl-cell--12-col\">
      <table class=\"mdl-data-table mdl-js-data-table\" id=\"impianti\" style=\"width: 100%;\">
      <tbody>";
        //getAmbienti(impianto) IMPIANTOSERVICES
        $ambienti = $DAOAmbiente->getFromIdImpianto($request->id);
        foreach ($ambienti as $j) {
            $myString .=
          "<tr>
            <td class=\"mdl-data-table__cell--non-numeric\" ng-click=\"addSoglia('addAmbiente',".$j->getId().",'".$j->getNome()."')\">".$j->getNome()."</td>
          </tr>";
        }
        $myString .=
      "</tbody>
      </table>
      </div>";
    } elseif ($request->cod == "getNomeSensore") {
        //getSensore(sogliaSensore)
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        $sensoreInstallato = $DAOSensoreInstallato->getFromId($request->id);
        $myString = $sensoreInstallato->getNome();
    } elseif ($request->cod == "getNomeAmbiente") {
        //getAmbiente(sogliaAmbiente)
        $DAOAmbiente = new DAOAmbiente();
        $ambiente = $DAOAmbiente->getFromId($request->id);
        $myString = $ambiente->getNome();
    } elseif ($request->cod == "getSoglie") {
        //getSoglieSensoreByImpianto(impianto)
        //getSoglieAmbienteByImpianto(impianto)
        $DAOSogliaSensore = new DAOSogliaSensore();
        $DAOSogliaAmbiente = new DAOSogliaAmbiente();
        $DAOAmbiente = new DAOAmbiente();
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        $soglieSensore = $DAOSogliaSensore -> getFromIdImpianto($request->id);
        $soglieAmbiente = $DAOSogliaAmbiente -> getFromIdImpianto($request->id);
        $myString = "<section class=\"section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp\">
        <div class=\"mdl-card mdl-cell mdl-cell--12-col\">
          <div class=\"mdl-card__supporting-text mdl-grid mdl-grid--no-spacing\">
            <h4 class=\"mdl-cell mdl-cell--12-col\">Soglie Sensori</h4>
            </div>
            <table class=\"mdl-data-table mdl-js-data-table\">
            <thead>
              <tr>
                <th class=\"mdl-data-table__cell--non-numeric\">Nome</th>
                <th class=\"mdl-data-table__cell--non-numeric\">Valore</th>
                <th class=\"mdl-data-table__cell--non-numeric\">Sensore</th>
              </tr>
            </thead>
            <tbody>";
        foreach ($soglieSensore as $i) {
            $toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
            if ($i->getMaggiore() != null) {
                $valoreSoglia = ">".$i->getMaggiore();
            } else {
                $valoreSoglia = "<".$i->getMinore();
            }
            $sensoreInstallato = $DAOSensoreInstallato -> getFromId($i->getIdSensoreInstallato());
            $nomeSensoreInstallato = $sensoreInstallato -> getNome();

            $myString .=
        //"<tr ng-click=\"soglieList.editDialog(\$event,'".$i->getId()."','".$i->getNome()."','".$i->getCognome()."','".$i->getEmail()."')\">
        "<tr ng-click=\"soglieList.editDialog(\$event,'modifica_sogliaSensore',".$toPass2.")\">
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$valoreSoglia."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$nomeSensoreInstallato."</td>
        </tr>";
        }
        $myString .=
    "</tbody>
      </table>
      <button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"add\" data-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"soglieList.addDialog(\$event, 'aggiungi_sogliaSensore')\">
          <i class=\"material-icons\">add</i>
      </button>
    </div>
    </section>";
        $myString .=
    "<section class=\"section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp\">
      <div class=\"mdl-card mdl-cell mdl-cell--12-col\">
        <div class=\"mdl-card__supporting-text mdl-grid mdl-grid--no-spacing\">
          <h4 class=\"mdl-cell mdl-cell--12-col\">Soglie Ambiente</h4>
          </div>
          <table class=\"mdl-data-table mdl-js-data-table\">
          <thead>
            <tr>
              <th class=\"mdl-data-table__cell--non-numeric\">Nome</th>
              <th class=\"mdl-data-table__cell--non-numeric\">Valore</th>
              <th class=\"mdl-data-table__cell--non-numeric\">Tipo</th>
              <th class=\"mdl-data-table__cell--non-numeric\">Ambiente</th>
            </tr>
          </thead>
          <tbody>";
        foreach ($soglieAmbiente as $i) {
            $toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
            if ($i->getMaggiore() != null) {
                $valoreSoglia = ">".$i->getMaggiore();
            } else {
                $valoreSoglia = "<".$i->getMinore();
            }
            $ambiente = $DAOAmbiente -> getFromId($i->getIdAmbiente());
            $nomeAmbiente = $ambiente -> getNome();

            $myString .=
            "<tr ng-click=\"soglieList.editDialog(\$event, 'modifica_sogliaAmbiente',".$toPass2.")\">
              <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
              <td class=\"mdl-data-table__cell--non-numeric\">".$valoreSoglia."</td>
              <td class=\"mdl-data-table__cell--non-numeric\">".$i->getTipo()."</td>
              <td class=\"mdl-data-table__cell--non-numeric\">".$nomeAmbiente."</td>
            </tr>";
        }
        $myString .=
          "</tbody>
              </table>
              <button class=\"mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon\" id=\"add\" data-upgraded=\",MaterialButton,MaterialRipple\" ng-click=\"soglieList.addDialog(\$event,'aggiungi_sogliaAmbiente')\">
                  <i class=\"material-icons\">add</i>
              </button>
            </div>
            </section>";
    } elseif ($request->cod == "getNomeTipologie") {
        $DAOSensoreInstallato = new DAOSensoreInstallato();
        $DAOSensore = new DAOSensore();
        $tipologie = array();
        $sensoriInstallati = $DAOSensoreInstallato->getFromIdAmbiente($request->id);
        foreach ($sensoriInstallati as $i) {
            $sensore = $DAOSensore -> getFromId($i->getIdSensore());
            array_push($tipologie, $sensore -> getTipo());
        }
        $tipologie_noDup = array_unique($tipologie);
        $myString = json_encode($tipologie_noDup);
    }
}
echo($myString);
