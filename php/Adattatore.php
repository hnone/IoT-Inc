<?php
class Adattatore {

	private	$adattatore;

	function __construct($adattatore) {
		$this->adattatore = $adattatore;
	}

	public function getAdattatore() { return $this->adattatore; }

  public function setAdattatore($adattatore) { $this->adattatore = $adattatore; }

}
?>
