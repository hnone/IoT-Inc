<?php

class DAOAmbiente {

  private $db;

  function __construct() {
		$this->db = Database::getInstance()->getConnection();
	}

  function insert($ambiente) {
    $nome = $terzaParte->getNome();
    $idImpianto = $terzaParte->getIdImpianto();

    $query = "INSERT INTO Ambiente (id, nome, idImpianto)
    VALUES (NULL, '$nome', '$idImpianto')";
    $this->db->query($query);
  }

  function getFromId($id) {
    $query = "SELECT * FROM Ambiente WHERE id = '$id'";
    $result = mysqli_query($this->db, $query) or die("Query fallita");
    $ambienti = self::creaAmbiente($result);
    return reset($ambienti);
  }

  function getFromImpianto($idImpianto) {
    $query = "SELECT * FROM Ambiente WHERE idImpianto = '$idImpianto'";
    $recordSet = mysqli_query($this->db, $query) or die("Query fallita") ;
    return self::creaAmbiente($recordSet);
  }

  function update($ambiente) {
    $id = $ambiente->getId();
    $nome = $ambiente->getNome();
    $idImpianto = $ambiente->getIdImpianto();

    $query = " UPDATE Ambiente
    SET nome = '$nome', idImpianto = '$idImpianto'
    WHERE id = '$id'";

    $this->db->query($query);
  }

  function delete($idAmbiente) {
    $query = "DELETE FROM Ambiente WHERE id = '$idAmbiente'";
    $this->db->query($query);
  }

  private function creaAmbiente($risultatoQuery) {
    $ambienti = array();
    while($row = mysqli_fetch_array($risultatoQuery)) {
      $id = $row["id"];
      $nome = $row["nome"];
      $idImpianto = $row["idImpianto"];

      $ambiente = new Ambiente($nome, $idImpianto);
      $ambiente -> setId($id);
      array_push($ambienti, $ambiente);
    }
    return $ambienti;
  }
}
 ?>
