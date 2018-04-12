<?php

class DAOCliente
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function update($cliente)
    {
        $id = $cliente->getId();
        $nome = $cliente->getNome();
        $cognome = $cliente->getCognome();
        $p_iva = $cliente->getPartitaIva();
        $email = $cliente->getEmail();
        $password = $cliente->getPassword();
        $tipo = $cliente->getTipo();

        $query = " UPDATE Cliente
    SET nome = '$nome', cognome = '$cognome', p_iva = '$p_iva', email = '$email', password = '$password', tipo = '$tipo'
    WHERE id = '$id'";

        $this->db->query($query);
    }

    public function getAll()
    {
        $query = "SELECT * FROM Cliente";
        $result = mysqli_query($this->db, $query);
        return self::creaCliente($result);
    }

    private function creaCliente($risultatoQuery)
    {
        $clienti = array();
        while ($row = mysqli_fetch_array($risultatoQuery)) {
            $id = $row["id"];
            $nome = $row["nome"];
            $cognome = $row["cognome"];
            $partitaIva = $row["p_iva"];
            $email = $row["email"];
            $password = $row["password"];
            $tipo = $row["tipo"];

            $cliente = new Cliente($nome, $cognome, $partitaIva, $email, $password);
            $cliente->setId($id);
            $cliente->setTipo($tipo);
            array_push($clienti, $cliente);
        }
        return $clienti;
    }

    public function get($email, $password)
    {
        $query = "SELECT * FROM Cliente WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($this->db, $query);
        $clienti = self::creaCliente($result);
        return reset($clienti);
    }

    public function getFromId($id)
    {
        $query = "SELECT * FROM Cliente WHERE id = '$id'";
        $result = mysqli_query($this->db, $query);
        $clienti = self::creaCliente($result);
        return reset($clienti);
    }

    public function insert($cliente)
    {
        $nome = $cliente->getNome();
        $cognome = $cliente->getCognome();
        $p_iva = $cliente->getPartitaIva();
        $email = $cliente->getEmail();
        $password = $cliente->getPassword();
        $tipo = $cliente->getTipo();
        $query = "INSERT INTO Cliente (id, nome, cognome, p_iva, email, password, tipo)
    VALUES (NULL, '$nome', '$cognome', '$p_iva', '$email', '$password', '$tipo')";

        $this->db->query($query);
    }

    public function delete($idCliente)
    {
        $query = "DELETE FROM Cliente WHERE id = '$idCliente'";
        $this->db->query($query);
    }
}
