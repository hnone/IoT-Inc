<?php

class DAOSensore{

  private $db;

  function __construct() {
		$this->db = Database::getInstance()->getConnection();
	}

  function update($sensore) {
    $id = $sensore->getId();
    $marca = $sensore->getMarca();
    $modello = $sensore->getModello();
    $tipo = $sensore->getTipo();
    $unitaMisura = $sensore->getUnitaMisura();

    $query = " UPDATE Sensore
    SET marca = '$marca', modello = '$modello', tipo = '$tipo', unitaMisura = '$unitaMisura'
    WHERE id = '$id'";

    $this->db->query($query);
  }

  function getAll() {
    $query = "SELECT * FROM Sensore";
    $recordSet = mysqli_query($this->db, $query);
    return self::creaSensore($recordSet);
  }

  function getFromId($id) {
    $query = "SELECT * FROM Sensore WHERE id = '$id'";
    $result = mysqli_query($this->db, $query);
    $Sensori = self::creaSensore($result);
    return reset($Sensori);
  }

  private function creaSensore($risultatoQuery) {
    $sensori = array();
    while($row = mysqli_fetch_array($risultatoQuery)) {
      $id = $row["id"];
      $marca = $row["marca"];
      $modello = $row["modello"];
      $tipo = $row["tipo"];
      $unitaMisura = $row["unitaMisura"];
      $sensore = new Sensore($marca, $modello, $tipo, $unitaMisura);
      $sensore -> setId($id);
      array_push($sensori, $sensore);
    }
    return $sensori;
  }

  function insert($sensore) {
    $marca = $sensore->getMarca();
    $modello = $sensore->getModello();
    $tipo = $sensore->getTipo();
    $unitaMisura = $sensore->getUnitaMisura();
    $query = "INSERT INTO Sensore (id, marca, modello, tipo, unitaMisura)
    VALUES (NULL, '$marca', '$modello', '$tipo', '$unitaMisura')";
    $this->db->query($query);
  }

  function delete($idSensore) {
    $query = "DELETE FROM Sensore WHERE id = '$idSensore'";
    $this->db->query($query);
  }

}
?>
