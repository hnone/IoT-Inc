<?php

class DAOSensoreInstallato{

  private $db;

  function __construct() {
		$this->db = Database::getInstance()->getConnection();
	}

  function update($sensoreInstallato) {
    $id = $sensoreInstallato->getId();
    $nome = $sensoreInstallato->getNome();
    $idSensore = $sensoreInstallato->getIdSensore();
    $idImpianto = $sensoreInstallato->getIdImpianto();
    $idAmbiente = $sensoreInstallato->getIdAmbiente();
    if (is_null($idAmbiente)) {
      $query = "UPDATE SensoreInstallato
      SET nome = '$nome', idSensore = '$idSensore', idImpianto = '$idImpianto', idAmbiente = NULL
      WHERE id = '$id'";
    } else {
      $query = "UPDATE SensoreInstallato
      SET nome = '$nome', idSensore = '$idSensore', idImpianto = '$idImpianto', idAmbiente = '$idAmbiente'
      WHERE id = '$id'";
    }

    $this->db->query($query) or die("Query fallita");
  }

  function getAll() {
    $query = "SELECT * FROM SensoreInstallato";
    $result = mysqli_query($this->db, $query) or die("Query fallita") ;
    return self::creaSensoreInstallato($result);
  }

  function getFromImpianto($idImpianto) {
    $query = "SELECT * FROM SensoreInstallato WHERE IdImpianto = '$idImpianto'";
    $result = mysqli_query($this->db, $query) or die("Query fallita") ;
    return self::creaSensoreInstallato($result);
  }

  function getFromId($idSensoreInstallato) {
    $query = "SELECT * FROM SensoreInstallato WHERE id = '$idSensoreInstallato'";
    $result = mysqli_query($this->db, $query) or die("Query fallita");
    $sensoriInstallati = self::creaSensoreInstallato($result);
    return reset($sensoriInstallati);
  }

  private function creaSensoreInstallato($risultatoQuery) {
    $sensoriInstallati = array();
    while($row = mysqli_fetch_array($risultatoQuery)) {
      $id = $row["id"];
      $nome = $row["nome"];
      $idSensore = $row["idSensore"];
      $idImpianto = $row["idImpianto"];
      $idAmbiente = $row["idAmbiente"];
      $sensoreInstallato = new SensoreInstallato($nome, $idSensore, $idImpianto);
      $sensoreInstallato->setId($id);
      $sensoreInstallato->setIdAmbiente($idAmbiente);
      array_push($sensoriInstallati, $sensoreInstallato);
    }
    return $sensoriInstallati;
  }

  function insert($sensoreInstallato) {
    $nome = $sensoreInstallato->getNome();
    $idSensore = $sensoreInstallato->getIdSensore();
    $idImpianto = $sensoreInstallato->getIdImpianto();
    $idAmbiente = $sensoreInstallato->getIdAmbiente();
    if (is_null($idAmbiente)) {
      $query = "INSERT INTO SensoreInstallato (id, nome, idSensore, idImpianto, idAmbiente)
      VALUES (NULL, '$nome', '$idSensore', '$idImpianto', NULL)";
    } else {
      $query = "INSERT INTO SensoreInstallato (id, nome, idSensore, idImpianto, idAmbiente)
      VALUES (NULL, '$nome', '$idSensore', '$idImpianto', '$idAmbiente')";
    }

    $this->db->query($query) or die("FALLITA");
  }

  function delete($idSensoreInstallato) {
    $query = "DELETE FROM SensoreInstallato WHERE id = '$idSensoreInstallato'";
    $this->db->query($query);
  }

}
?>