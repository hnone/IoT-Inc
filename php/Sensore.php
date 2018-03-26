<?php
class Sensore {

	private	$id;
	private	$marca;
	private	$modello;
	private	$tipo;
	private $unitaMisura;

	function __construct($marca, $modello, $tipo, $unitaMisura) {
		$this->marca = $marca;
		$this->modello = $modello;
		$this->tipo = $tipo;
    $this->unitaMisura = $unitaMisura;
	}

	public function getId() { return $this->id; }

  public function getMarca() { return $this->marca; }

  public function getModello() { return $this->modello; }

  public function getTipo() { return $this->tipo; }

  public function getUnitaMisura() { return $this->unitaMisura; }

  public function setId($id) { $this->id = $id; }

  public function setNome($marca) { $this->marca = $marca; }

  public function setCognome($modello) { $this->modello = $modello; }

  public function setPartitaIva($tipo) { $this->tipo = $tipo; }

  public function setEmail($unitaMisura) { $this->unitaMisura = $unitaMisura; }
}
?>
