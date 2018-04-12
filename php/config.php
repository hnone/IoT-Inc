<?php
class Database
{
    private $host = "79.8.96.3:3306";
    private $user = "hnone";
    private $password = "hnone";
    private $db = "iot_inc";
    private $connessione;

    private static $instance;

    private function __construct()
    {
        $this->connessione = new mysqli($this->host, $this->user, $this->password, $this->db);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connessione;
    }
}
