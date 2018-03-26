<?php
class Autorizzazione {

	private	$id;
	private	$idTerzaParte;
	private	$idImpianto;
  private $idAmbiente;
	private	$idSensoreInstallato;

	function __construct($idTerzaParte, $cognome, $email, $idCliente) {
		$this->nome = $nome;
		$this->cognome = $cognome;
    $this->email = $email;
		$this->idCliente = $idCliente;
	}

	public function getId() { return $this->id; }

  public function getNome() { return $this->nome; }

  public function getCognome() { return $this->cognome; }

  public function getEmail() { return $this->email; }

  public function getIdCliente() {return $this->idCliente; }

  public function setId($id) { $this->id = $id; }

  public function setNome($nome) { $this->nome = $nome; }

  public function setCognome($cognome) { $this->cognome = $cognome; }

  public function setEmail($email) { $this->email = $email; }

  public function setIdCliente($idCliente) {$this->idCliente = $idCliente; }

}
?>
