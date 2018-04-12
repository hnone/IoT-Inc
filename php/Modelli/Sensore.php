<?php
class Sensore implements JsonSerializable
{
    private $id;
    private $marca;
    private $modello;
    private $tipo;
    private $unitaMisura;

    public function __construct($marca, $modello, $tipo, $unitaMisura)
    {
        $this->marca = $marca;
        $this->modello = $modello;
        $this->tipo = $tipo;
        $this->unitaMisura = $unitaMisura;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function getModello()
    {
        return $this->modello;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getUnitaMisura()
    {
        return $this->unitaMisura;
    }

    public function getNome()
    {
        return $this->getMarca()." - ".$this->getModello()." - ".$this->getTipo();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function setModello($modello)
    {
        $this->modello = $modello;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setUnitaMisura($unitaMisura)
    {
        $this->unitaMisura = $unitaMisura;
    }

    public function jsonSerialize()
    {
        return array(
            'id'=>$this->id,
      'marca'=>$this->marca,
            'modello'=>$this->modello,
      'tipo'=>$this->tipo,
            'unitaMisura'=>$this->unitaMisura
        );
    }
}
