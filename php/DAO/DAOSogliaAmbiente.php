<?php
class DAOSogliaAmbiente
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($sogliaAmbiente)
    {
        $nome = $sogliaAmbiente->getNome();
        $maggiore = $sogliaAmbiente->getMaggiore();
        $minore = $sogliaAmbiente->getMinore();
        $tipo = $sogliaAmbiente->getTipo();
        $idAmbiente = $sogliaAmbiente->getIdAmbiente();
        if (is_null($maggiore)) {
            $query = "INSERT INTO SogliaAmbiente(id, nome, maggiore, minore, tipo, idAmbiente)
      VALUES (NULL, '$nome', NULL, '$minore', '$tipo', '$idAmbiente')";
        } else {
            $query = "INSERT INTO SogliaAmbiente(id, nome, maggiore, minore, tipo, idAmbiente)
      VALUES (NULL, '$nome', '$maggiore', NULL, '$tipo', '$idAmbiente')";
        }

        $this->db->query($query);
    }

    public function getFromIdImpianto($idImpianto)
    {
        $query = "SELECT SogliaAmbiente.id, SogliaAmbiente.nome, SogliaAmbiente.maggiore, SogliaAmbiente.minore, SogliaAmbiente.tipo, SogliaAmbiente.idAmbiente
              FROM SogliaAmbiente INNER JOIN Ambiente ON SogliaAmbiente.idAmbiente = Ambiente.id
              WHERE idImpianto = '$idImpianto'";
        $result = mysqli_query($this->db, $query);
        return self::creaSogliaAmbiente($result);
    }

    public function getFromId($id)
    {
        $query = "SELECT * FROM SogliaAmbiente WHERE id = '$id'";
        $result = mysqli_query($this->db, $query);
        $soglieAmbiente = self::creaSogliaAmbiente($result);
        return reset($soglieAmbiente);
    }

    public function getAll()
    {
        $query = "SELECT * FROM SogliaAmbiente";
        $result = mysqli_query($this->db, $query);
        return self::creaSogliaAmbiente($result);
    }

    public function update($sogliaAmbiente)
    {
        $id = $sogliaAmbiente->getId();
        $nome = $sogliaAmbiente->getNome();
        $maggiore = $sogliaAmbiente->getMaggiore();
        $minore = $sogliaAmbiente->getMinore();
        $tipo = $sogliaAmbiente->getTipo();
        $idAmbiente = $sogliaAmbiente->getIdAmbiente();
        if (is_null($maggiore)) {
            $query = " UPDATE SogliaAmbiente
      SET nome = '$nome', maggiore = NULL, minore = '$minore', tipo = '$tipo', idAmbiente = '$idAmbiente'
      WHERE id = '$id'";
        } else {
            $query = " UPDATE SogliaAmbiente
      SET nome = '$nome', maggiore = '$maggiore', minore = NULL, tipo = '$tipo', idAmbiente = '$idAmbiente'
      WHERE id = '$id'";
        }
        $this->db->query($query);
    }


    public function delete($idSogliaAmbiente)
    {
        $query = "DELETE FROM SogliaAmbiente WHERE id = '$idSogliaAmbiente'";
        $this->db->query($query);
    }

    private function creaSogliaAmbiente($risultatoQuery)
    {
        $soglieAmbienti = array();
        while ($row = mysqli_fetch_array($risultatoQuery)) {
            $id = $row["id"];
            $nome = $row["nome"];
            $maggiore = $row["maggiore"];
            $minore = $row["minore"];
            $tipo = $row["tipo"];
            $idAmbiente = $row["idAmbiente"];

            $sogliaAmbiente = new SogliaAmbiente($nome, $maggiore, $minore, $tipo, $idAmbiente);
            $sogliaAmbiente->setId($id);
            array_push($soglieAmbienti, $sogliaAmbiente);
        }
        return $soglieAmbienti;
    }
}
