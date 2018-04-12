<?php
class SensoreInstallato implements JsonSerializable
{
    private $id;
    private $nome;
    private $idSensore;
    private $idImpianto;
    private $idAmbiente;

    public function __construct($nome, $idSensore, $idImpianto, $idAmbiente)
    {
        $this->nome = $nome;
        $this->idSensore = $idSensore;
        $this->idImpianto = $idImpianto;
        $this->idAmbiente = $idAmbiente;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getIdSensore()
    {
        return $this->idSensore;
    }

    public function getIdImpianto()
    {
        return $this->idImpianto;
    }

    public function getIdAmbiente()
    {
        return $this->idAmbiente;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setIdSensore($idSensore)
    {
        $this->idSensore = $idSensore;
    }

    public function setIdImpianto($idImpianto)
    {
        $this->idImpianto = $idImpianto;
    }

    public function setIdAmbiente($idAmbiente)
    {
        $this->idAmbiente = $idAmbiente;
    }

    public function jsonSerialize()
    {
        return array(
            'id'=>$this->id,
            'nome'=>$this->nome,
            'idSensore'=>$this->idSensore,
            'idImpianto'=>$this->idImpianto,
            'idAmbiente'=>$this->idAmbiente
        );
    }
}
