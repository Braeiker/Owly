<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "owly_db";

// Creazione della connessione al database
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Verifica il metodo della richiesta
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica i parametri GET per il filtraggio
    $filtroNome = isset($_GET['nome']) ? $_GET['nome'] : '';
    $filtroMateria = isset($_GET['materia']) ? $_GET['materia'] : '';
    $filtroPostiDisponibili = isset($_GET['posti_disponibili']) ? intval($_GET['posti_disponibili']) : null;

    // Costruisci la query SQL basata sui filtri
    $query = "SELECT * FROM corsi WHERE 1";

    if (!empty($filtroNome)) {
        $query .= " AND nome LIKE '%$filtroNome%'";
    }
    if (!empty($filtroMateria)) {
        $query .= " AND materia LIKE '%$filtroMateria%'";
    }
    if ($filtroPostiDisponibili !== null) {
        $query .= " AND posti_disponibili >= $filtroPostiDisponibili";
    }

    // Esegui la query
    $result = $conn->query($query);

    if ($result === false) {
        die("Errore nella query: " . $conn->error);
    }

    $corsi = array();

    while ($row = $result->fetch_assoc()) {
        $corsi[] = $row;
    }

    echo json_encode($corsi);
} else {
    echo json_encode(array("error" => "Metodo non supportato"));
}

// Chiudi la connessione al database
$conn->close();
