<?php

class DAOAmbiente
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($ambiente)
    {
        $nome = $ambiente->getNome();
        $idImpianto = $ambiente->getIdImpianto();

        $query = "INSERT INTO Ambiente (id, nome, idImpianto)
    VALUES (NULL, '$nome', '$idImpianto')";
        $this->db->query($query);
    }

    public function getFromId($id)
    {
        $query = "SELECT * FROM Ambiente WHERE id = '$id'";
        $result = mysqli_query($this->db, $query);
        $ambienti = self::creaAmbiente($result);
        return reset($ambienti);
    }

    public function getFromIdImpianto($idImpianto)
    {
        $query = "SELECT * FROM Ambiente WHERE idImpianto = '$idImpianto'";
        $recordSet = mysqli_query($this->db, $query);
        return self::creaAmbiente($recordSet);
    }

    public function update($ambiente)
    {
        $id = $ambiente->getId();
        $nome = $ambiente->getNome();
        $idImpianto = $ambiente->getIdImpianto();

        $query = " UPDATE Ambiente
    SET nome = '$nome', idImpianto = '$idImpianto'
    WHERE id = '$id'";

        $this->db->query($query);
    }

    public function delete($idAmbiente)
    {
        $query = "DELETE FROM Ambiente WHERE id = '$idAmbiente'";
        $this->db->query($query);
    }

    private function creaAmbiente($risultatoQuery)
    {
        $ambienti = array();
        while ($row = mysqli_fetch_array($risultatoQuery)) {
            $id = $row["id"];
            $nome = $row["nome"];
            $idImpianto = $row["idImpianto"];

            $ambiente = new Ambiente($nome, $idImpianto);
            $ambiente -> setId($id);
            array_push($ambienti, $ambiente);
        }
        return $ambienti;
    }
}
