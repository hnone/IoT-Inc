<?php
class FileWriter
{
    private $path;
    private $file;

    public function __construct($path)
    {
        $this->path = $path;
        $this->file = fopen($path, "w");
    }

    public function writeLine($line)
    {
        fwrite($this->file, $line);
        fwrite($this->file, "\r\n");
    }

    public function closeFile()
    {
        fclose($this->file);
    }
}
