<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../Owly/corsi_db.php");
include("../Owly/gestione_corsi.php");
include("../Owly/owly_database.php");
include("../Owly/database.php");

$database = new Database();
$db = $database->getConnection();

$corso = new Corsi($db);

$data = json_decode(file_get_contents("php://input"));

$corso->nome_corso = $data->Nome_corso;
$corso->numero_studenti = $data->Numero_studenti;

if ($corso->update()) {
    http_response_code(200);
    echo json_encode(array("risposta" => "Corso aggiornato"));
} else {
    // 503 service unavailable
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile aggiornare il corso"));
}
?>
