<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "owly_db";

function connectToDatabase($servername, $username, $password, $database) {
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    return $conn;
}

function fetchCorsi($conn, $filtroNome, $filtroId) {
    $query = "SELECT nome_corso, id FROM corsi WHERE 1";

    if (!empty($filtroNome)) {
        $query .= " AND nome_corso LIKE '%$filtroNome%'";
    }
    if ($filtroId !== null) {
        $query .= " AND (id = ? OR ? IS NULL)";
    }

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Errore nella preparazione della query: " . $conn->error);
    }

    if ($filtroId !== null) {
        $stmt->bind_param("is", $filtroId, $filtroId);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    $corsi = array();

    while ($row = $result->fetch_assoc()) {
        $corsi[] = $row;
    }

    $stmt->close();

    return $corsi;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectToDatabase($servername, $username, $password, $database);

    $data = json_decode(file_get_contents("php://input"));

    // Verifica che i dati siano presenti e che siano un oggetto JSON valido
    if ($data && is_object($data)) {
        $filtroNome = isset($data->filtroNome) ? htmlspecialchars(strip_tags($data->filtroNome)) : null;
        $filtroId = isset($data->filtroId) ? intval($data->filtroId) : null;

        $corsi = fetchCorsi($conn, $filtroNome, $filtroId);

        echo json_encode($corsi);

    } else {
        echo json_encode(array("error" => "Dati JSON non validi"));
        http_response_code(400);  // Bad Request
        exit();
    }

} else {
    echo json_encode(array("error" => "Metodo non supportato"));
    http_response_code(405);  // Method Not Allowed
    exit();
}
?>
