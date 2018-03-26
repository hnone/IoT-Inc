<?php

class DAOTerzaParte{

  private $db;

  function __construct() {
		$this->db = Database::getInstance()->getConnection();
	}

  function update($idTerzaParte, $nome, $cognome, $email, $tempo) {
    $query = " UPDATE TerzaParte
    SET nome = '$nome', cognome = '$cognome', email = '$email', tempo = '$tempo'
    WHERE id = '$idTerzaParte'";

    $this->db->query($query);
  }

  function updateUltimoInvio($idTerzaParte, $ultimoInvio) {
    $query = " UPDATE TerzaParte
    SET ultimoInvio = '$ultimoInvio'
    WHERE id = '$idTerzaParte'";

    $this->db->query($query);
  }

  function getAll() {
    $query = "SELECT * FROM TerzaParte";
    $recordSet = mysqli_query($this->db, $query) or die("Query fallita");
    return self::creaTerzaParte($recordSet);
  }

  function getFromIdCliente($idCliente) {
    $query = "SELECT * FROM TerzaParte WHERE idCliente = '$idCliente'";
    $recordSet = mysqli_query($this->db, $query) or die("Query fallita") ;
    return self::creaTerzaParte($recordSet);
  }

  function getFromCliente($cliente) {
    $query = "SELECT * FROM TerzaParte WHERE idCliente = " .$cliente->getId() ;
    $recordSet = mysqli_query($this->db, $query) or die("Query fallita") ;
    return self::creaTerzaParte($recordSet);
  }

  function getFromId($id) {
    $query = "SELECT * FROM TerzaParte WHERE id = '$id'";
    $result = mysqli_query($this->db, $query) or die("Query fallita");
    $terzeparti = self::creaTerzaParte($result);
    return reset($terzeparti);
  }

  private function creaTerzaParte($risultatoQuery) {
    $terzeParti = array();
    while($row = mysqli_fetch_array($risultatoQuery)) {
      $id = $row["id"];
      $nome = $row["nome"];
      $cognome = $row["cognome"];
      $email = $row["email"];
      $tempo = $row["tempo"];
      $ultimoInvio = $row["ultimoInvio"];
      $idCliente = $row["idCliente"];

      $terzaParte = new TerzaParte($nome, $cognome, $email, $tempo, $idCliente);
      $terzaParte->setId($id);
      $terzaParte->setUltimoInvio($ultimoInvio);
      array_push($terzeParti, $terzaParte);
    }
    return $terzeParti;
  }

  function insert($terzaParte) {
    $nome = $terzaParte->getNome();
    $cognome = $terzaParte->getCognome();
    $email = $terzaParte->getEmail();
    $tempo = $terzaParte->getTempo();
    $idCliente = $terzaParte->getIdCliente();

    $query = "INSERT INTO TerzaParte (id, nome, cognome, email, idCliente, tempo)
    VALUES (NULL, '$nome', '$cognome', '$email', '$idCliente', '$tempo')";
    $this->db->query($query);
  }

  function delete($idTerzaParte) {
    $query = "DELETE FROM TerzaParte WHERE id = '$idTerzaParte'";
    $this->db->query($query);
  }

}
?>
