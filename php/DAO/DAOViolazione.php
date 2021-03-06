<?php

require_once 'DAOSogliaSensore.php';
require_once 'SogliaSensore.php';
require_once 'DAOSogliaAmbiente.php';
require_once 'SogliaAmbiente.php';

class DAOViolazione
{
    private $db;
    private $daoSogliaSensore = new DAOSogliaSensore();
    private $daoSogliaAmbiente = new DAOSogliaAmbiente();

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getSoglieSensoreViolate($idRilevazione)
    {
        $idSoglieViolate = array();

        $query = "SELECT * FROM ViolazioneSensore WHERE idRilevazione = '$idRilevazione' AND violata = 1";
        $risultatoQuery = mysqli_query($this->db, $query);

        while ($row = mysqli_fetch_array($risultatoQuery)) {
            array_push($idSoglieViolate, $row["idSogliaSensoreInstallato"]);
        }

        $soglieViolate = array();
        foreach ($idSoglieViolate as $currentId) {
            array_push($soglieViolate, $this->daoSogliaSensore->getFromId($currentId));
        }

        return $soglieViolate;
    }

    public function getSoglieAmbienteViolate($idRilevazione)
    {
        $idSoglieViolate = array();

        $query = "SELECT * FROM ViolazioneAmbiente WHERE idRilevazione = '$idRilevazione' AND violata = 1";
        $risultatoQuery = mysqli_query($this->db, $query);

        while ($row = mysqli_fetch_array($risultatoQuery)) {
            array_push($idSoglieViolate, $row["idSogliaAmbiente"]);
        }

        $soglieViolate = array();
        foreach ($idSoglieViolate as $currentId) {
            array_push($soglieViolate, $this->daoSogliaAmbiente->getFromId($currentId));
        }

        return $soglieViolate;
    }
}
