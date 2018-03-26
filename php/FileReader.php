<?php
class FileReader {

	private	$adattatore;
  private $path;

	function __construct($path) {
    	$this->path = $path;
  }

	public function readAll() {
    $adattatori = array();
    $myfile = fopen($this->path, "r") or die("Unable to open file!");
    while(!feof($myfile)) {
      $adattatore = fgets($myfile);
      array_push($adattatori, $adattatore);
    }
    fclose($myfile);
    return $adattatori;
  }

  public function deleteFile() {
    if (file_exists("$this->path")) {
       unlink($this->path);
       $myfile = fopen($this->path, "w");
       fclose($myfile);
    }
  }

}
?>
