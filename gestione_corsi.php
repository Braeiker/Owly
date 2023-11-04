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
            $query = "SELECT
                nome_corso,
                numero_studenti
                FROM
                " . $this->table_name;
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            // Handle errors here, for example, log the error or return an error message
            echo "Error in query: " . $e->getMessage();
            return null;
        }
    }

    // CREATE corsi
    function create(){
        try {
            $query = "INSERT INTO " . $this->table_name . "
                SET
                nome_corso = :nome_corso, numero_studenti = :numero_studenti";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $this->nome_corso = htmlspecialchars(strip_tags($this->nome_corso));
            $this->numero_studenti = htmlspecialchars(strip_tags($this->numero_studenti));
            
            // Bind parameters
            $stmt->bindParam(":nome_corso", $this->nome_corso);
            $stmt->bindParam(":numero_studenti", $this->numero_studenti);

            if($stmt->execute()){
                return true;
            }

            return false;
        } catch (PDOException $e) {
            // Handle errors for database operations
            echo "Error in create: " . $e->getMessage();
            return false;
        }
    }

    // UPDATE corsi
    function update(){
        try {
            $query = "UPDATE " . $this->table_name . "
                SET
                nome_corso = :nome_corso, numero_studenti = :numero_studenti
                WHERE nome_corso = :nome_corso";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $this->nome_corso = htmlspecialchars(strip_tags($this->nome_corso));
            $this->numero_studenti = htmlspecialchars(strip_tags($this->numero_studenti));
            
            // Bind parameters
            $stmt->bindParam(":nome_corso", $this->nome_corso);
            $stmt->bindParam(":numero_studenti", $this->numero_studenti);

            if($stmt->execute()){
                return true;
            }

            return false;
        } catch (PDOException $e) {
            // Handle errors for database operations
            echo "Error in update: " . $e->getMessage();
            return false;
        }
    }

    // DELETE corsi
    function delete(){
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE nome_corso = :nome_corso";
            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $this->nome_corso = htmlspecialchars(strip_tags($this->nome_corso));
            
            // Bind parameters
            $stmt->bindParam(":nome_corso", $this->nome_corso);

            if($stmt->execute()){
                return true;
            }

            return false;
        } catch (PDOException $e) {
            // Handle errors for database operations
            echo "Error in delete: " . $e->getMessage();
            return false;
        }
    }
}
?>
