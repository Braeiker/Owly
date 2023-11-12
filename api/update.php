<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../corsiDb.php");
include("../gestioneCorsi.php");
include("../owlyDatabase.php");
include("../database.php");

$database = new Database();
$db = $database->getConnection();

$corso = new Corsi($db);

$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->nome_corso) && isset($data->numero_studenti)) {
    $corso->nome_corso = $data->nome_corso;
    $corso->numero_studenti = $data->numero_studenti;

    if ($corso->update()) {
        http_response_code(200);
        echo json_encode(array("risposta" => "Corso aggiornato"));
    } else {
        // 503 service unavailable
        http_response_code(503);
        echo json_encode(array("risposta" => "Impossibile aggiornare il corso"));
    }
} else {
    // 400 Bad Request
    http_response_code(400);
    echo json_encode(array("risposta" => "Dati incompleti o non validi"));
}
?>
