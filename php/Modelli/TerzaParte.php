<?php
class TerzaParte implements JsonSerializable
{
    private $id;
    private $nome;
    private $cognome;
    private $email;
    private $tempo;
    private $ultimoInvio;
    private $idCliente;

    public function __construct($nome, $cognome, $email, $tempo, $idCliente)
    {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->tempo = $tempo;
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

    public function getCognome()
    {
        return $this->cognome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTempo()
    {
        return $this->tempo;
    }

    public function getUltimoInvio()
    {
        return $this->ultimoInvio;
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

    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTempo($tempo)
    {
        $this->tempo = $tempo;
    }

    public function setUltimoInvio($ultimoInvio)
    {
        $this->ultimoInvio = $ultimoInvio;
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
            'cognome'=>$this->cognome,
      'email'=>$this->email,
            'tempo'=>$this->tempo,
      'ultimoInvio'=>$this->ultimoInvio,
            'idCliente'=>$this->idCliente
        );
    }
}
