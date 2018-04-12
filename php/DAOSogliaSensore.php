<?php
class DAOSogliaSensore {

  private $db;

  function __construct() {
		$this->db = Database::getInstance()->getConnection();
	}

  function insert($sogliaSensore) {
    $nome = $sogliaSensore->getNome();
    $maggiore = $sogliaSensore->getMaggiore();
    $minore = $sogliaSensore->getMinore();
    $idSensoreInstallato = $sogliaSensore->getIdSensoreInstallato();
    if (is_null($maggiore)) {
      $query = "INSERT INTO SogliaSensoreInstallato (id, nome, maggiore, minore, idSensoreInstallato)
      VALUES (NULL, '$nome', NULL, '$minore', '$idSensoreInstallato')";
    } else {
      $query = "INSERT INTO SogliaSensoreInstallato (id, nome, maggiore, minore, idSensoreInstallato)
      VALUES (NULL, '$nome', '$maggiore', NULL, '$idSensoreInstallato')";
    }

    $this->db->query($query);
  }

  function getFromIdImpianto($idImpianto) {
    $query = "SELECT sogliasensoreinstallato.id, sogliasensoreinstallato.nome, maggiore, minore, idSensoreInstallato
              FROM SogliaSensoreInstallato INNER JOIN SensoreInstallato ON sogliasensoreinstallato.idSensoreInstallato = sensoreinstallato.id
              WHERE idImpianto = '$idImpianto'";
    $result = mysqli_query($this->db, $query);
    return self::creaSogliaSensore($result);
  }

  function getFromId($id) {
    $query = "SELECT * FROM SogliaSensoreInstallato WHERE id = '$id'";
    $result = mysqli_query($this->db, $query);
    $soglieSensore = self::creaSogliaSensore($result);
    return reset($soglieSensore);
  }

  function getAll() {
    $query = "SELECT * FROM SogliaSensoreInstallato";
    $result = mysqli_query($this->db, $query);
    return self::creaSogliaSensore($result);
  }

  function update($sogliaSensore) {
    $id = $sogliaSensore->getId();
    $nome = $sogliaSensore->getNome();
    $maggiore = $sogliaSensore->getMaggiore();
    $minore = $sogliaSensore->getMinore();
    $idSensoreInstallato = $sogliaSensore->getIdSensoreInstallato();
    if (is_null($maggiore)) {
      $query = " UPDATE SogliaSensoreInstallato
      SET nome = '$nome', maggiore = NULL, minore = '$minore', idSensoreInstallato = '$idSensoreInstallato'
      WHERE id = '$id'";
    } else {
      $query = " UPDATE SogliaSensoreInstallato
      SET nome = '$nome', maggiore = '$maggiore', minore = NULL, idSensoreInstallato = '$idSensoreInstallato'
      WHERE id = '$id'";
    }
    
    $this->db->query($query);
  }

  function delete($idSogliaSensore) {
    $query = "DELETE FROM SogliaSensoreInstallato WHERE id = '$idSogliaSensore'";
    $this->db->query($query);
  }

  private function creaSogliaSensore($risultatoQuery) {
    $soglieSensori = array();
    while($row = mysqli_fetch_array($risultatoQuery)) {
      $id = $row["id"];
      $nome = $row["nome"];
      $maggiore = $row["maggiore"];
      $minore = $row["minore"];
      $idSensoreInstallato = $row["idSensoreInstallato"];

      $sogliaSensore = new SogliaSensore($nome, $maggiore, $minore, $idSensoreInstallato);
      $sogliaSensore->setId($id);
      array_push($soglieSensori, $sogliaSensore);
    }
    return $soglieSensori;
  }
}

?>
