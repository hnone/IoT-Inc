<?php
class Impianto implements JsonSerializable
{
    private $id;
    private $nome;
    private $tipo;
    private $idCliente;

    public function __construct($nome, $tipo, $idCliente)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->idCliente = $idCliente;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }


    public function jsonSerialize()
    {
        return array(
                'id'=>$this->id,
                'nome'=>$this->nome,
                'tipo'=>$this->tipo,
                'idCliente'=>$this->idCliente
            );
    }
}
