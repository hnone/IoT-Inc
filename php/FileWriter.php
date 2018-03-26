<?php
class FileWriter {
  private $path;
  private $file;

  function __construct($path) {
    $this->path = $path;
    $this->file = fopen($path, "w");
  }

  function writeLine($line) {
    fwrite($this->file, $line);
    fwrite($this->file, "\r\n");
  }

  function closeFile() {
    fclose($this->file);
  }

}
?>
