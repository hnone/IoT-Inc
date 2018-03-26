<?php
class CreaAdattatori {
	const IMPIANTO = 2;
	private	$numAdattatori;
  private $path;

	function __construct($path, $numAdattatori) {
		$this->path = $path;
		$this->numAdattatori = $numAdattatori;
	}

	public function create() {
    $myfile = fopen($this->path, "w") or die("Unable to open file!");
    for ($i = 1; $i <= $this->numAdattatori; $i++) {
      $id = self::createIdentificatore();
      $body = self::createBody();
      $message = self::createMessage();
      $stringa = $id.$body.$message;
			if($i == $this->numAdattatori) {
      	fwrite($myfile, "$stringa");
			} else {
				fwrite($myfile, "$stringa\n");
			}
    }
    fclose($myfile);
  }

  public function createIdentificatore() {
    $daoSensoreInstallato = new DAOSensoreInstallato();
    $sensoriInstallati = $daoSensoreInstallato->getFromImpianto(self::IMPIANTO);
    $size = sizeof($sensoriInstallati);
    $rand = rand(0, $size - 1);
    $id = $sensoriInstallati[$rand]->getId();
    if(strlen($id) == 2) {
      $id = "0".$id;
    }
		if(strlen($id) == 1) {
      $id = "00".$id;
    }
    return $id;
  }

  public function createBody() {
    $probability = array(0, 0, 0, 0, 0, 1);
    $rand = rand(0, sizeof($probability) - 1);
    $today = date('dmYHis');
    $body = $probability[$rand].$today;
    $rand = rand(50000, 100000);
    $body = $body.$rand;
    return $body;
  }

  public function createMessage() {
    $array = array("#MESSAGGIO", "#PROVA", "#CTF OK!", "#CW", "#S&D", "#CAEU", "#DOTA");
    $rand = rand(0, sizeof($array) - 1);
    return $array[$rand];
  }

}
?>
