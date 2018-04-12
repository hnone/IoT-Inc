<?php
include '../session.php';
include '../DAO/DAOSensore.php';
include '../Modelli/Sensore.php';

$DAOSensore = new DAOSensore();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if ($request->cod == "add") {
        $DAOSensore-> insert(new Sensore($request->marca, $request->modello, $request->tipo, $request->unitaMisura));
    } elseif ($request->cod == "edit") {
        $toUpdate = new Sensore($request->marca, $request->modello, $request->tipo, $request->unitaMisura);
        $toUpdate -> setId($request->id);
        $DAOSensore -> update($toUpdate);
    } elseif ($request->cod == "remove") {
        $DAOSensore -> delete($request->id);
    } elseif ($request->cod == "getAll") {
        $DAOSensore = new DAOSensore();
        $sensori = $DAOSensore -> getAll();
        $myString = "";
        foreach ($sensori as $i) {
            $toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
            $myString .=
        "<tr ng-click=\"sensoriList.editDialog(\$event,".$toPass2.")\">
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getMarca()."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getModello()."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getTipo()."</td>
          <td class=\"mdl-data-table__cell--non-numeric\">".$i->getUnitaMisura()."</td>
        </tr>";
        }
    }
}
