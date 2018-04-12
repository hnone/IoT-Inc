<?php

class DAOImpianto {

  private $db;

  function __construct() {
		$this->db = Database::getInstance()->getConnection();
	}

  function update($impianto) {
    $id = $impianto->getId();
    $nome = $impianto->getNome();
    $tipo = $impianto->getTipo();
    $idCliente = $impianto->getIdCliente();

    if (is_null($idCliente)) {
      $query = " UPDATE Impianto
      SET nome = '$nome', tipo = '$tipo', idCliente = NULL
      WHERE id = '$id'";
    } else {
      $query = " UPDATE Impianto
      SET nome = '$nome', tipo = '$tipo', idCliente = '$idCliente'
      WHERE id = '$id'";
    }

    $this->db->query($query);
  }
  /*

  function getFromCliente($cliente) {
    $query = "SELECT * FROM Impianto WHERE idCliente = ". $cliente->getId();
    $recordSet = mysqli_query($this->db, $query);
    return self::creaImpianto($recordSet);
  }
*/

  function getAll() {
    $query = "SELECT * FROM Impianto";
    $recordSet = mysqli_query($this->db, $query);
    return self::creaImpianto($recordSet);
  }

  function getFromIdCliente($idCliente) {
    $query = "SELECT * FROM Impianto WHERE idCliente = '$idCliente'";
    $recordSet = mysqli_query($this->db, $query);
    return self::creaImpianto($recordSet);
  }

  function getFromId($id) {
    $query = "SELECT * FROM Impianto WHERE id = '$id'";
    $result = mysqli_query($this->db, $query);
    $impianti = self::creaImpianto($result);
    return reset($impianti);
  }

  private function creaImpianto($risultatoQuery) {
    $impianti = array();
    while($row = mysqli_fetch_array($risultatoQuery)) {
      $id = $row["id"];
      $nome = $row["nome"];
      $tipo = $row["tipo"];
      $idCliente = $row["idCliente"];
      $impianto = new Impianto($nome, $tipo, $idCliente);
      $impianto -> setId($id);
      array_push($impianti, $impianto);
    }
    return $impianti;
  }

  function insert($impianto) {
    $nome = $impianto->getNome();
    $tipo = $impianto->getTipo();
    $idCliente = $impianto->getIdCliente();
    if(is_null($idCliente)) {
      $query = "INSERT INTO Impianto (id, nome, tipo, idCliente)
      VALUES (NULL, '$nome', '$tipo', NULL)";
    } else {
      $query = "INSERT INTO Impianto (id, nome, tipo, idCliente)
      VALUES (NULL, '$nome', '$tipo', '$idCliente')";
    }
    $this->db->query($query);
  }

  function delete($idImpianto) {
    $query = "DELETE FROM Impianto WHERE id = '$idImpianto'";
    $this->db->query($query);
  }

}
?>
