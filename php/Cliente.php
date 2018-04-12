<?php
class Cliente implements JsonSerializable {

	private	$id;
	private	$nome;
	private	$cognome;
	private	$partitaIva;
	private $email;
	private $password;
	private $tipo = "UTENTE";

	function __construct($nome, $cognome, $partitaIva, $email, $password) {
		$this->nome = $nome;
		$this->cognome = $cognome;
		$this->partitaIva = $partitaIva;
		$this->email = $email ;
		$this->password = $password;
	}

	public function isAmministratore() {
		if ($this->tipo == "AMMINISTRATORE") {
			return true;
		} else {
			return false;
		}
	}

	public function getId() { return $this->id; }

  public function getNome() { return $this->nome; }

  public function getCognome() { return $this->cognome; }

  public function getPartitaIva() { return $this->partitaIva; }

  public function getEmail() { return $this->email; }

  public function getPassword() { return $this->password; }

  public function getTipo() { return $this->tipo; }

  public function setId($id) { $this->id = $id; }

  public function setNome($nome) { $this->nome = $nome; }

  public function setCognome($cognome) { $this->cognome = $cognome; }

  public function setPartitaIva($partitaIva) { $this->partitaIva = $partitaIva; }

  public function setEmail($email) { $this->email = $email; }

  public function setPassword($password) { $this->password = $password; }

  public function setTipo($tipo) { $this->tipo = $tipo; }

	public function jsonSerialize() {
		return array(
			'id'=>$this->id,
			'nome'=>$this->nome,
			'cognome'=>$this->cognome,
			'email'=>$this->email,
			'password'=>$this->password,
			'partitaIva'=>$this->partitaIva
		);
	}

}
?>
