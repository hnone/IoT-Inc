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

    $query = " UPDATE Impianto
    SET nome = '$nome', tipo = '$tipo', idCliente = '$idCliente'
    WHERE id = '$id'";

    $this->db->query($query);
  }

  function getFromCliente($cliente) {
    $query = "SELECT * FROM Impianto WHERE idCliente = ". $cliente->getId();
    $recordSet = mysqli_query($this->db, $query) or die("Query fallita") ;
    return self::creaImpianto($recordSet);
  }

  function getFromIdCliente($idCliente) {
    $query = "SELECT * FROM Impianto WHERE idCliente = '$idCliente'";
    $recordSet = mysqli_query($this->db, $query) or die("Query fallita") ;
    return self::creaImpianto($recordSet);
  }

  function getFromId($id) {
    $query = "SELECT * FROM Impianto WHERE id = '$id'";
    $result = mysqli_query($this->db, $query) or die("Query fallita");
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
    $query = "INSERT INTO Impianto (id, nome, tipo, idCliente)
    VALUES (NULL, '$nome', '$tipo', '$idCliente')";
    $this->db->query($query);
  }

  function delete($idImpianto) {
    $query = "DELETE FROM Impianto WHERE id = '$idImpianto'";
    $this->db->query($query);
  }

}
?>
