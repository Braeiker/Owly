<?php
// Intestazioni
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include i file necessari (sostituisci con i percorsi corretti)
include("../Owly/corsi_db.php");
include("../Owly/gestione_corsi.php");
include("../Owly/owly_database.php");
include("../Owly/database.php");

// Inizializza la connessione al database
$database = new Database();
$db = $database->getConnection();

// Crea un nuovo oggetto Corso
$corso = new Corsi($db);

// Ottieni e decodifica i dati JSON in ingresso
$data = json_decode(file_get_contents("php://input"));

// Imposta le proprietà dell'oggetto Corso
$corso->nome_corso = $data->Nome_corso;
$corso->numero_studenti = $data->Numero_studenti;

// Tentativo di eliminare il corso
if ($corso->delete()) {
    // 200 OK
    http_response_code(200);
    echo json_encode(array("risposta" => "Il corso è stato eliminato"));
} else {
    // 503 Servizio non disponibile
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile eliminare il corso."));
}
?>
