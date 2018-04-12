<?php
include '../session.php';
include '../DAO/DAOAmbiente.php';
include '../DAO/DAOSensoreInstallato.php';
include '../DAO/DAOSensore.php';
include '../DAO/DAORilevazione.php';
include '../DAO/DAOViolazione.php';
include '../Modelli/Ambiente.php';
include '../Modelli/SensoreInstallato.php';
include '../Modelli/Sensore.php';
include '../Modelli/Rilevazione.php';

$DAOSensoreInstallato = new DAOSensoreInstallato();
$DAOAmbiente = new DAOAmbiente();
$DAOSensore = new DAOSensore();
$DAORilevazione = new DAORilevazione();
$DAOViolazione = new DAOViolazione();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if ($request->cod == "setIdImpianto") {
        $htmlString = "<section class=\"section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp\">
                    <div class=\"mdl-card mdl-cell mdl-cell--12-col\" style=\"background-color: #ff000014;\">
                    <div class=\"mdl-card__supporting-text mdl-grid mdl-grid--no-spacing\">
                      <h4 class=\"mdl-cell mdl-cell--12-col\">Eccezioni Rilevate</h4>
                      </div>
                      <table class=\"mdl-data-table mdl-js-data-table\">
                      <thead>
                        <tr>
                          <th class=\"mdl-data-table__cell--non-numeric\">Sensore</th>
                          <th class=\"mdl-data-table__cell--non-numeric\">Ambiente</th>
                          <th class=\"mdl-data-table__cell--non-numeric\">Data\Ora</th>
                          <th class=\"mdl-data-table__cell--non-numeric\">Tipo</th>
                          <th class=\"mdl-data-table__cell--non-numeric\">Messaggio</th>
                          <th class=\"mdl-data-table__cell--non-numeric\">Errore</th>
                        </tr>
                      </thead>
                      <tbody>";
        $eccezioni = $DAORilevazione -> getEccezioniImpianto($request->id);
        if (empty($eccezioni)) {
            $htmlString .= "<tr><td class=\"mdl-data-table__cell--non-numeric\">Non ci sono eccezioni</td>";
        } else {
            foreach ($eccezioni as $j) {
                $sensoreInstallato = $DAOSensoreInstallato -> getFromId($j->getIdSensoreInstallato());
                $nomeSensoreInstallato = $sensoreInstallato -> getNome();
                $idSensoreAssociatoalSensoreInstallato = $sensoreInstallato -> getIdSensore();
                $ambiente = $DAOAmbiente -> getFromId($sensoreInstallato->getIdAmbiente());
                $sensore = $DAOSensore -> getFromId($idSensoreAssociatoalSensoreInstallato);
                $tipoSensore = $sensore -> getTipo();
                $unitaSensore = $sensore -> getUnitaMisura();
                if ($ambiente) {
                    $nomeAmbiente = $ambiente->getNome();
                } else {
                    $nomeAmbiente = "";
                }
                $htmlString .=
                          "<tr ng-click=\"chooseSensoreInstallato(\$event,".$j->getIdSensoreInstallato().",'".$tipoSensore."','".$unitaSensore."')\">
                              <td class=\"mdl-data-table__cell--non-numeric\">".$nomeSensoreInstallato."</td>
                              <td class=\"mdl-data-table__cell--non-numeric\">".$nomeAmbiente."</td>
                              <td class=\"mdl-data-table__cell--non-numeric\">".$j->getData()."</td>
                              <td class=\"mdl-data-table__cell--non-numeric\">".$tipoSensore."</td>
                              <td class=\"mdl-data-table__cell--non-numeric\">".$j->getMessaggio()."</td>
                              <td class=\"mdl-data-table__cell--non-numeric\">".$j->getErrore()."</td>
                            </tr>";
            }
        }

        $htmlString .= "</tbody>
                                </table>
                                </div>
                                </section>";


        $htmlString .= "
                    <section class=\"section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp\">
                      <div class=\"mdl-card mdl-cell mdl-cell--12-col\">
                        <div class=\"mdl-card__supporting-text mdl-grid mdl-grid--no-spacing\">
                          <h4 class=\"mdl-cell mdl-cell--12-col\">Ultime Rilevazioni</h4>
                          </div>
                          <table class=\"mdl-data-table mdl-js-data-table\">
                          <thead>
                          <tr>
                            <th class=\"mdl-data-table__cell--non-numeric\">Sensore</th>
                            <th class=\"mdl-data-table__cell--non-numeric\">Ambiente</th>
                            <th class=\"mdl-data-table__cell--non-numeric\">Data\Ora</th>
                            <th class=\"mdl-data-table__cell--non-numeric\">Tipo</th>
                            <th class=\"mdl-data-table__cell--non-numeric\">Soglie Violate</th>
                            <th>Valore</th>
                            </tr>
                            </thead>
                            <tbody>";
        //$toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
        $rilevazioni = $DAORilevazione -> getRilevazioniImpianto($request->id);
        if (empty($rilevazioni)) {
            $htmlString .= "<tr><td class=\"mdl-data-table__cell--non-numeric\">Non ci sono rilevazioni</td>";
        } else {
            foreach ($rilevazioni as $j) {
                $style = "";
                $sensoreInstallato = $DAOSensoreInstallato -> getFromId($j->getIdSensoreInstallato());
                $nomeSensoreInstallato = $sensoreInstallato -> getNome();
                $idSensoreAssociatoalSensoreInstallato = $sensoreInstallato -> getIdSensore();
                $ambiente = $DAOAmbiente -> getFromId($sensoreInstallato->getIdAmbiente());
                $sensore = $DAOSensore -> getFromId($idSensoreAssociatoalSensoreInstallato);
                $tipoSensore = $sensore -> getTipo();
                $unitaSensore = $sensore -> getUnitaMisura();
                $soglieSensoreViolate = $DAOViolazione -> getSoglieSensoreViolate($j->getId());
                $violazioni = "";
                foreach ($soglieSensoreViolate as $violazione) {
                    $violazioni .= $violazione -> getNome();
                    $style = "style=\"background-color: #ffd20066;\"";
                }
                $soglieAmbienteViolate = $DAOViolazione -> getSoglieAmbienteViolate($j->getId());
                foreach ($soglieAmbienteViolate as $violazione) {
                    $violazioni .= $violazione -> getNome();
                    $style = "style=\"background-color: #ffd20066;\"";
                }
                if ($ambiente) {
                    $nomeAmbiente = $ambiente->getNome();
                } else {
                    $nomeAmbiente = "";
                }
                $htmlString .=
      //"<tr ng-click=\"questList.editDialog(\$event,'".$i->getId()."','".$i->getNome()."','".$i->getCognome()."','".$i->getEmail()."')\">
      "<tr ng-click=\"chooseSensoreInstallato(\$event,".$j->getIdSensoreInstallato().",'".$tipoSensore."','".$unitaSensore."')\"".$style.">
        <td class=\"mdl-data-table__cell--non-numeric\">".$nomeSensoreInstallato."</td>
        <td class=\"mdl-data-table__cell--non-numeric\">".$nomeAmbiente."</td>
        <td class=\"mdl-data-table__cell--non-numeric\">".$j->getData()."</td>
        <td class=\"mdl-data-table__cell--non-numeric\">".$tipoSensore."</td>
        <td class=\"mdl-data-table__cell--non-numeric\">".$violazioni."</td>
        <td class=\"mdl-data-table__cell\">".$j->getValore().$unitaSensore."</td>
      </tr>";
            }
        }

        $htmlString .= "</tbody>
                    </table>
                    </div>
                    </section>";


        echo $htmlString;
    } elseif ($request->cod == "setIdSensoreInstallato") {
        $sensoreInstallato = $DAOSensoreInstallato -> getFromId($request->id);
        $nomeSensoreInstallato = $sensoreInstallato -> getNome();
        $idSensoreAssociatoalSensoreInstallato = $sensoreInstallato -> getIdSensore();
        $ambiente = $DAOAmbiente -> getFromId($sensoreInstallato->getIdAmbiente());
        $sensore = $DAOSensore -> getFromId($idSensoreAssociatoalSensoreInstallato);
        $tipoSensore = $sensore -> getTipo();
        $unitaSensore = $sensore -> getUnitaMisura();
        if ($ambiente) {
            $nomeAmbiente = $ambiente->getNome();
        } else {
            $nomeAmbiente = "";
        }
        $htmlString = "<section class=\"section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp\">
                    <div class=\"mdl-card mdl-cell mdl-cell--12-col\">
                    <div class=\"mdl-card__supporting-text mdl-grid mdl-grid--no-spacing\">
                      <h4 class=\"mdl-cell mdl-cell--12-col\">".$nomeSensoreInstallato." (".$nomeAmbiente.") - ".$tipoSensore."</h4>
                      </div>
                      <table class=\"mdl-data-table mdl-js-data-table\">
                      <thead>
                        <tr>
                          <th class=\"mdl-data-table__cell--non-numeric\">Data\Ora</th>
                          <th class=\"mdl-data-table__cell--non-numeric\">Messaggio</th>
                          <th class=\"mdl-data-table__cell--non-numeric\">Errore</th>
                          <th class=\"mdl-data-table__cell\">Valore</th>
                        </tr>
                      </thead>
                      <tbody>";
        $rilevazioniEccezioni = $DAORilevazione -> getRilevazioniEccezioniSensore($request->id);
        if (empty($rilevazioniEccezioni)) {
            $htmlString .= "<tr><td class=\"mdl-data-table__cell--non-numeric\">Non ci sono rilevazioni</td>";
        } else {
            foreach ($rilevazioniEccezioni as $j) {
                if ($j->isEccezione()) {
                    $htmlString .=
                              "<tr ng-click=\"chooseSensoreInstallato(\$event,".$j->getIdSensoreInstallato().")\" style=\"background-color: #ff000014;\">";
                } else {
                    $htmlString .=
                              "<tr ng-click=\"chooseSensoreInstallato(\$event,".$j->getIdSensoreInstallato().")\">";
                }
                $htmlString .=
                          "<td class=\"mdl-data-table__cell--non-numeric\">".$j->getData()."</td>
                          <td class=\"mdl-data-table__cell--non-numeric\">".$j->getMessaggio()."</td>
                          <td class=\"mdl-data-table__cell--non-numeric\">".$j->getErrore()."</td>";

                if ($j->isEccezione()) {
                    $htmlString .= "<td class=\"mdl-data-table__cell\"></td></tr>";
                } else {
                    $htmlString .= "<td class=\"mdl-data-table__cell\">".$j->getValore().$unitaSensore."</td> </tr>";
                }
            }
        }

        $htmlString .= "</tbody>
                            </table>
                            </div>
                            </section>";

        echo $htmlString;
    } elseif ($request->cod == "getRilevazioniSensDate") {
        $rilevazioniEccezioniData = $DAORilevazione -> getRilevazioniEccezioniData($request->id, $request->dateFrom, $request->dateTo);
        $toPass = json_encode($rilevazioniEccezioniData);
        echo $toPass;
    }
}
