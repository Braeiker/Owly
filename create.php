<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include necessary files
include("../Owly/corsi_db.php");
include("../Owly/gestione_corsi.php");
include("../Owly/owly_database.php");
include("../Owly/database.php");

// Initialize database and objects
$database = new Database();
$db = $database->getConnection();
$corso = new Corsi($db);

// Get and decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"));

if ($data) {
    if (!empty($data->Nome_corso) && !empty($data->Numero_studenti)) {
        $corso->nome_corso = $data->Nome_corso;
        $corso->numero_studenti = $data->Numero_studenti;

        // Attempt to create a course record
        if ($corso->create()) {
            // 201 Created
            http_response_code(201);
            echo json_encode(array("message" => "Corso creato correttamente."));
        } else {
            // 503 Service Unavailable
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile creare il corso."));
        }
    } else {
        // 400 Bad Request
        http_response_code(400);
        echo json_encode(array("message" => "Impossibile creare il corso: dati incompleti."));
    }
} else {
    // 400 Bad Request (JSON parsing failed)
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare il corso: parsing JSON fallito."));
}
