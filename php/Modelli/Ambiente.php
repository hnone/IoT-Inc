<?php
class Ambiente
{
    private $id;
    private $nome;
    private $idImpianto;

    public function __construct($nome, $idImpianto)
    {
        $this->nome = $nome;
        $this->idImpianto = $idImpianto;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getIdImpianto()
    {
        return $this->idImpianto;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setIdImpianto($idImpianto)
    {
        $this->idImpianto = $idImpianto;
    }
}
