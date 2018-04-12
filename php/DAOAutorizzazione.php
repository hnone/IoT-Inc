<?php

require_once 'DAOAmbiente.php';
require_once 'DAOImpianto.php';
require_once 'DAOSensoreInstallato.php';

class DAOAutorizzazione{

  private $db;
  private $daoImpianto;
  private $daoAmbiente;
  private $daoSensoreInstallato;

  function __construct() {
		$this->db = Database::getInstance()->getConnection();
    $this->daoImpianto = new DAOImpianto();
    $this->daoAmbiente = new DAOAmbiente();
    $this->daoSensoreInstallato = new DAOSensoreInstallato();
	}

  function insertImpianto($idTerzaParte, $idImpianto) {
    $query = "INSERT INTO Autorizzazione (id, idTerzaParte, idImpianto, idAmbiente, idSensoreInstallato)
    VALUES (NULL, '$idTerzaParte', '$idImpianto', NULL, NULL)";
    $this->db->query($query);
  }

  function insertAmbiente($idTerzaParte, $idAmbiente) {
    $query = "INSERT INTO Autorizzazione (id, idTerzaParte, idImpianto, idAmbiente, idSensoreInstallato)
    VALUES (NULL, '$idTerzaParte', NULL, '$idAmbiente', NULL)";
    $this->db->query($query);
  }

  function insertSensoreInstallato($idTerzaParte, $idSensoreInstallato) {
    $query = "INSERT INTO Autorizzazione (id, idTerzaParte, idImpianto, idAmbiente, idSensoreInstallato)
    VALUES (NULL, '$idTerzaParte', NULL, NULL, '$idSensoreInstallato')";
    $this->db->query($query);
  }

  function removeImpianto($idTerzaParte, $idImpianto) {
    $query = "DELETE FROM Autorizzazione WHERE idTerzaParte = '$idTerzaParte' AND idImpianto = '$idImpianto'";
    $this->db->query($query);
  }

  function removeAmbiente($idTerzaParte, $idAmbiente) {
    $query = "DELETE FROM Autorizzazione WHERE idTerzaParte = '$idTerzaParte' AND idAmbiente = '$idAmbiente'";
    $this->db->query($query);
  }

  function removeSensoreInstallato($idTerzaParte, $idSensoreInstallato) {
    $query = "DELETE FROM Autorizzazione WHERE idTerzaParte = '$idTerzaParte' AND idSensoreInstallato = '$idSensoreInstallato'";
    $this->db->query($query);
  }

  function getImpianti($idTerzaParte) {
    $idImpianti = array();

    $query = "SELECT DISTINCT idImpianto FROM Autorizzazione WHERE idTerzaParte = '$idTerzaParte' AND idImpianto IS NOT NULL";
    $risultatoQuery = mysqli_query($this->db, $query);

    while($row = mysqli_fetch_array($risultatoQuery)) {
      array_push($idImpianti, $row["idImpianto"]);
    }

    $impianti = array();
    foreach ($idImpianti as $currentId) {
      array_push($impianti, $this->daoImpianto->getFromId($currentId));
    }

    return $impianti;
  }

  function getAmbienti($idTerzaParte) {
    $idAmbienti = array();

    $query = "SELECT DISTINCT idAmbiente FROM Autorizzazione WHERE idTerzaParte = '$idTerzaParte' AND idAmbiente IS NOT NULL";
    $risultatoQuery = mysqli_query($this->db, $query);

    while($row = mysqli_fetch_array($risultatoQuery)) {
      array_push($idAmbienti, $row["idAmbiente"]);
    }

    $ambienti = array();
    foreach ($idAmbienti as $currentId) {
      array_push($ambienti, $this->daoAmbiente->getFromId($currentId));
    }

    return $ambienti;
  }

  function getSensoriInstallati($idTerzaParte) {
    $idSensoriInstallati = array();

    $query = "SELECT DISTINCT idSensoreInstallato FROM Autorizzazione WHERE idTerzaParte = '$idTerzaParte' AND idSensoreInstallato IS NOT NULL";
    $risultatoQuery = mysqli_query($this->db, $query);

    while($row = mysqli_fetch_array($risultatoQuery)) {
      array_push($idSensoriInstallati, $row["idSensoreInstallato"]);
    }

    $sensoriInstallati = array();
    foreach ($idSensoriInstallati as $currentId) {
      array_push($sensoriInstallati, $this->daoSensoreInstallato->getFromId($currentId));
    }

    return $sensoriInstallati;
  }

}
?>
