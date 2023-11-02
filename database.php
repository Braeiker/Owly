<?php
class Database {
    // Credenziali del database Owly
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $database = "owly_db"; 
    public $conn;

    // Connessione al database
    public function getConnection() {
        $this->conn = null;
        try {
            // Utilizza il nome del database nella connessione
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Errore di connessione: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>