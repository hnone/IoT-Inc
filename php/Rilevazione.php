<?php
class Rilevazione implements JsonSerializable {

	private	$id;
	private	$idSensoreInstallato;
	private	$data;
	private $valore;
	private $errore;
	private $messaggio;

	function __construct() {
		$args = func_get_args();
 		switch( func_num_args() ) {
 			case 1:
 				self::__construct1($args[0]);
 			break;
 		}
	}

  function __construct1($adattatore) {
		$explodeString = "#";
    $exploded = explode($explodeString, $adattatore->getAdattatore());
    $corpo = $exploded[0];
    $messaggio = $exploded[1];
    $this->idSensoreInstallato = substr($corpo, 0, 3);
    $err = substr($corpo,3,1);
		$tempOra = substr($corpo,12,6);
    $ora = substr($tempOra,0,2).":".substr($tempOra,2,2).":".substr($tempOra,4);
    $tempData = substr($corpo,4,8);
		$tempData =substr($tempData,4)."-".substr($tempData,2,2)."-".substr($tempData,0,2);
    $this->data = $tempData." ".$ora;
    if($err == "0") {
			$temp = substr($corpo,18);
      $this->valore = ($temp / 1000);
      $this->errore = null;
    } else {
      $this->errore = substr($corpo,18);
      $this->valore = null;
    }
    $this->messaggio = $messaggio;
	}

	public function isEccezione() { return is_null($this->valore); }

	public function getId() { return $this->id; }

  public function getIdSensoreInstallato() { return $this->idSensoreInstallato; }

  public function getData() { return $this->data; }

  public function getValore() { return $this->valore; }

  public function getErrore() { return $this->errore; }

  public function getMessaggio() { return $this->messaggio; }

  public function setId($id) { $this->id = $id; }

  public function setIdSensoreInstallato($idSensoreInstallato) { $this->idSensoreInstallato = $idSensoreInstallato; }

  public function setData($data) { $this->data = $data; }

  public function setValore($valore) { $this->valore = $valore; }

  public function setErrore($errore) { $this->errore = $errore; }

  public function setMessaggio($messaggio) { $this->messaggio = $messaggio; }

	public function jsonSerialize() {
    return array(
			'id'=>$this->id,
      'idSensoreInstallato'=>$this->idSensoreInstallato,
			'data'=>$this->data,
      'valore'=>$this->valore,
			'errore'=>$this->errore,
      'messaggio'=>$this->messaggio
		);
	}

}
?>
