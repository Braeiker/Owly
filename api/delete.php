<?php
// Intestazioni
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include i file necessari (sostituisci con i percorsi corretti)
include("../corsiDb.php");
include("../gestioneCorsi.php");
include("../owlyDatabase.php");
include("../database.php");

// Verifica se sono stati inviati dati JSON
$data = json_decode(file_get_contents("php://input"));

if (empty($data)) {
    // 400 Bad Request
    http_response_code(400);
    echo json_encode(array("risposta" => "Nessun dato JSON ricevuto"));
    exit;
}


try {
    // Inizializza la connessione al database
    $database = new Database();
    $db = $database->getConnection();

    // Crea un nuovo oggetto Corso
    $corso = new Corsi($db);


    // Verifica se $data contiene la proprietà desiderata
    if (isset($data->nome_corso) && isset($data->Id)) {
        // Imposta le proprietà dell'oggetto Corso
        $corso->nome_corso = $data->nome_corso;
        $corso->id = $data->Id;

        // Verifica se il corso esiste prima di tentare di eliminarlo
        if ($corso->corsoExists()) {
            // Tentativo di eliminare il corso
            if ($corso->delete()) {
                // 200 OK
                http_response_code(200);
                echo json_encode(array("risposta" => "Il corso è stato eliminato" . $data->nome_corso));
            } else {
                // 503 Servizio non disponibile
                http_response_code(503);
                echo json_encode(array("risposta" => "Impossibile eliminare il corso."));
            }
        } else {
            // 404 Not Found
            http_response_code(404);
            echo json_encode(array("risposta" => "Il corso non è presente nel database"));
        }
    } else {
        // 400 Bad Request
        http_response_code(400);
        echo json_encode(array("risposta" => "Dati incompleti o non validi. Assicurati di fornire il campo 'nome_corso'."));
    }
} catch (Exception $e) {
    // 500 Internal Server Error
    http_response_code(500);
    echo json_encode(array("risposta" => "Errore interno del server: " . $e->getMessage()));
}
?>
