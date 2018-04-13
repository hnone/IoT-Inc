<?php
include '../session.php';
include '../DAO/DAOSensore.php';
include '../Modelli/Sensore.php';


class ServizioSensore {
  private $DAOSensore = new DAOSensore();
  function __construct() {  }
  function addSensore($sensore) {
    $this->DAOSensore -> insert($sensore);
  }
  function deleteSensore($sensoreId) {
    $this->DAOSensore -> delete($sensoreId);
  }
  function editSensore($sensore) {
    $this->DAOSensore -> edit($sensore);
  }
  function getAll() {
    return $this->DAOSensore -> getAll($sensore);
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $servizioSensore = new ServizioSensore();
    if ($request->cod == "add") {
        $servizioSensore -> addSensore(new Sensore($request->marca, $request->modello, $request->tipo, $request->unitaMisura));
    } elseif ($request->cod == "edit") {
        $toUpdate = new Sensore($request->marca, $request->modello, $request->tipo, $request->unitaMisura);
        $toUpdate -> setId($request->id);
        $servizioSensore -> update($toUpdate);
    } elseif ($request->cod == "remove") {
        $servizioSensore -> deleteSensore($request->id);
    } elseif ($request->cod == "getAll") {
        echo json_encode($servizioSensore -> getAll());
    }
}
