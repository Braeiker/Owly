<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include i file necessari
include("../corsiDb.php");
include("../gestioneCorsi.php");
include("../owlyDatabase.php");
include("../database.php");

// Creazione dell'oggetto del database
$database = new Database();
$db = $database->getConnection();
$corso = new Corsi($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Verifica se la richiesta è di tipo GET
    $stmt = $corso->read();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $corsi_arr = array();
        $corsi_arr["Materie Corsi"] = array(); // Inizializza l'array "records"

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $corso_item = array(
                "nome_corso" => $nome_corso,
                "Numero_posti_disponibili" => (int)$numero_studenti  // Cast a intero
            );
            array_push($corsi_arr["Materie Corsi"], $corso_item);
        }

        echo json_encode($corsi_arr);
    } else {
        echo json_encode(array("error" => "Nessun corso trovato"));
    }
} else {
    http_response_code(405); // Metodo non consentito (Metodo diverso da GET)
    echo json_encode(array("error" => "Metodo non consentito"));
}
?>
