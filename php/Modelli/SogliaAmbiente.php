<?php
class SogliaAmbiente implements JsonSerializable
{
    private $id;
    private $nome;
    private $maggiore;
    private $minore;
    private $tipo;
    private $idAmbiente;

    public function __construct($nome, $maggiore, $minore, $tipo, $idAmbiente)
    {
        $this->nome = $nome;
        $this->maggiore = $maggiore;
        $this->minore = $minore;
        $this->tipo = $tipo;
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

    public function getMaggiore()
    {
        return $this->maggiore;
    }

    public function getMinore()
    {
        return $this->minore;
    }

    public function getTipo()
    {
        return $this->tipo;
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

    public function setMaggiore($maggiore)
    {
        $this->maggiore = $maggiore;
    }

    public function setMinore($minore)
    {
        $this->minore = $minore;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setIdAmbiente($idAmbiente)
    {
        $this->idAmbiente = $idAmbiente;
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
      'tipo'=>$this->tipo,
            'idAmbiente'=>$this->idAmbiente
        );
    }
}
