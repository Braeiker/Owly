<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class Database {
    private $host = "127.0.0.1";
    private $db_name = "owly_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            http_response_code(500);
            echo json_encode(array("error" => "Connection error: " . $exception->getMessage()));
            exit;
        }

        return $this->conn;
    }
}

class Corsi {
    private $conn;
    private $table_name = "corsi";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);

        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $exception) {
            http_response_code(500);
            echo json_encode(array("error" => "Query execution error: " . $exception->getMessage()));
            exit;
        }
    }
}

$database = new Database();
$db = $database->getConnection();
$corso = new Corsi($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $corso->read();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $corsi_arr = array();
        $corsi_arr["Materie Corsi"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $corso_item = array(
                "nome_corso" => $nome_corso,
                "Numero_posti_disponibili" => (int)$numero_studenti
            );
            array_push($corsi_arr["Materie Corsi"], $corso_item);
        }

        echo json_encode($corsi_arr);
    } else {
        http_response_code(404);
        echo json_encode(array("error" => "Nessun corso trovato"));
    }
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Metodo non consentito"));
}
?>
