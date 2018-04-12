<?php
class SogliaSensore implements JsonSerializable
{
    private $id;
    private $nome;
    private $maggiore;
    private $minore;
    private $idSensoreInstallato;

    public function __construct($nome, $maggiore, $minore, $idSensoreInstallato)
    {
        $this->nome = $nome;
        $this->maggiore = $maggiore;
        $this->minore = $minore;
        $this->idSensoreInstallato = $idSensoreInstallato;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getMaggiore()
    {
        return $this->maggiore;
    }

    public function getMinore()
    {
        return $this->minore;
    }

    public function getIdSensoreInstallato()
    {
        return $this->idSensoreInstallato;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setMaggiore($maggiore)
    {
        $this->maggiore = $maggiore;
    }

    public function setMinore($minore)
    {
        $this->minore = $minore;
    }

    public function setIdSensoreInstallato($idSensoreInstallato)
    {
        $this->idSensoreInstallato = $idSensoreInstallato;
    }

    public function jsonSerialize()
    {
        if (!is_null($this->maggiore)) {
            $maggMin = "maggiore";
            $valore = $this->maggiore;
        } else {
            $maggMin = "minore";
            $valore = $this->minore;
        }
        return array(
            'id'=>$this->id,
            'nome'=>$this->nome,
            'maggMin'=>$maggMin,
            'valore'=>$valore,
            'idSensore'=>$this->idSensoreInstallato
        );
    }
}
