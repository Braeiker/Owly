<?php
class Corsi 
{
    private $conn;
    private $table_name = "Corsi"; 

    public $nome_corso;
    public $numero_studenti;

    // Costruttore
    public function __construct($database)
    {
        $this->conn = $database;
    }

    // READ corsi 
    function read()
    {
        try {
            // Seleziona tutto
            $query = "SELECT
                nome_corso,
                numero_studenti
                FROM
                " . $this->table_name;
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            // Gestisci gli errori qui, ad esempio, registra l'errore o restituisci un messaggio di errore
            echo "Errore nella query: " . $e->getMessage();
            return null;
        }
    }
}

?>
