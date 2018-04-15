<?php

require_once 'DAOAmbiente.php';
require_once 'DAOImpianto.php';
require_once 'DAOSensoreInstallato.php';

class DAORilevazione
{
    private $db;
    private $daoImpianto = new DAOImpianto();
    private $daoAmbiente = new DAOAmbiente();
    private $daoSensoreInstallato = new DAOSensoreInstallato();

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function update($rilevazione)
    {
        $id = $rilevazione->getId();
        $idSensoreInstallato = $rilevazione->getIdSensoreInstallato();
        $data = $rilevazione->getData();
        $valore = $rilevazione->getValore();
        $errore = $rilevazione->getErrore();
        $messaggio = $rilevazione->getMessaggio();

        $query = " UPDATE Rilevazione
    SET idSensoreInstallato = '$idSensoreInstallato', data = '$data', valore = '$valore', errore = '$errore', messaggio = '$messaggio'
    WHERE id = '$id'";

        $this->db->query($query);
    }

    public function getAll()
    {
        $query = "SELECT * FROM Rilevazione";
        $result = mysqli_query($this->db, $query);
        return self::creaRilevazione($result);
    }

    public function getRilevazioniImpianto($idImpianto)
    {
        $query = "SELECT Rilevazione.id, Rilevazione.idSensoreInstallato, Rilevazione.data, Rilevazione.valore, Rilevazione.errore, Rilevazione.messaggio
              FROM SensoreInstallato INNER JOIN Rilevazione ON SensoreInstallato.id = Rilevazione.idSensoreInstallato
              WHERE SensoreInstallato.idImpianto = '$idImpianto' AND Rilevazione.errore IS null ORDER BY Rilevazione.data DESC";
        $result = mysqli_query($this->db, $query);
        return self::creaRilevazione($result);
    }

    public function getEccezioniImpianto($idImpianto)
    {
        $query = "SELECT Rilevazione.id, Rilevazione.idSensoreInstallato, Rilevazione.data, Rilevazione.valore, Rilevazione.errore, Rilevazione.messaggio
              FROM SensoreInstallato INNER JOIN Rilevazione ON SensoreInstallato.id = Rilevazione.idSensoreInstallato
              WHERE SensoreInstallato.idImpianto = '$idImpianto' AND Rilevazione.valore IS null ORDER BY Rilevazione.data DESC";
        $result = mysqli_query($this->db, $query);
        return self::creaRilevazione($result);
    }

    public function getRilevazioniEccezioniSensore($idSensoreInstallato)
    {
        $query = "SELECT Rilevazione.id, Rilevazione.idSensoreInstallato, Rilevazione.data, Rilevazione.valore, Rilevazione.errore, Rilevazione.messaggio
              FROM SensoreInstallato INNER JOIN Rilevazione ON SensoreInstallato.id = Rilevazione.idSensoreInstallato
              WHERE SensoreInstallato.id = '$idSensoreInstallato' ORDER BY Rilevazione.data DESC";
        $result = mysqli_query($this->db, $query);
        return self::creaRilevazione($result);
    }

    public function getRilevazioniEccezioniAmbiente($idAmbiente)
    {
        $query = "SELECT Rilevazione.id, Rilevazione.idSensoreInstallato, Rilevazione.data, Rilevazione.valore, Rilevazione.errore, Rilevazione.messaggio
              FROM SensoreInstallato INNER JOIN Rilevazione ON sensoreinstallato.id = rilevazione.idSensoreInstallato
              WHERE sensoreinstallato.idAmbiente = '$IdAmbiente' ORDER BY rilevazione.data DESC";
        $result = mysqli_query($this->db, $query);
        return self::creaRilevazione($result);
    }

    public function getRilevazioniEccezioniData($idSensoreInstallato, $data1, $data2)
    {
        $query = "SELECT Rilevazione.id, Rilevazione.idSensoreInstallato, Rilevazione.data, Rilevazione.valore, Rilevazione.errore, Rilevazione.messaggio
              FROM SensoreInstallato INNER JOIN Rilevazione ON SensoreInstallato.id = Rilevazione.idSensoreInstallato
              WHERE SensoreInstallato.id = '$idSensoreInstallato' AND Rilevazione.data BETWEEN '$data1' AND '$data2' ORDER BY Rilevazione.data DESC";
        $result = mysqli_query($this->db, $query);
        return self::creaRilevazione($result);
    }

    private function creaRilevazione($risultatoQuery)
    {
        $rilevazioni = array();
        while ($row = mysqli_fetch_array($risultatoQuery)) {
            $rilevazione = new Rilevazione();
            $rilevazione->setId($row["id"]);
            $rilevazione->setIdSensoreInstallato($row["idSensoreInstallato"]);
            $rilevazione->setData($row["data"]);
            $rilevazione->setValore($row["valore"]);
            $rilevazione->setErrore($row["errore"]);
            $rilevazione->setMessaggio($row["messaggio"]);
            array_push($rilevazioni, $rilevazione);
        }
        return $rilevazioni;
    }

    public function getFromId($id)
    {
        $query = "SELECT * FROM Rilevazione WHERE id = '$id'";
        $result = mysqli_query($this->db, $query);
        $rilevazioni = self::creaRilevazione($result);
        return reset($rilevazioni);
    }

    public function insert($rilevazione)
    {
        $idSensoreInstallato = $rilevazione->getIdSensoreInstallato();
        $data = $rilevazione->getData();
        $valore = $rilevazione->getValore();
        $errore = $rilevazione->getErrore();
        $messaggio = $rilevazione->getMessaggio();
        if (is_null($errore)) {
            $query = "INSERT INTO Rilevazione (id, idSensoreInstallato, data, valore, errore, messaggio)
      VALUES (NULL, '$idSensoreInstallato', '$data', '$valore', NULL, '$messaggio')";
        } else {
            $query = "INSERT INTO Rilevazione (id, idSensoreInstallato, data, valore, errore, messaggio)
      VALUES (NULL, '$idSensoreInstallato', '$data', NULL, '$errore', '$messaggio')";
        }

        $this->db->query($query);
    }

    public function delete($idRilevazione)
    {
        $query = "DELETE FROM Cliente WHERE id = '$idRilevazione'";
        $this->db->query($query);
    }
}
