<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "owly_db"; 

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Creazione della tabella 
  $createTableSQL = "CREATE TABLE IF NOT EXISTS Corsi (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_corso VARCHAR(30) NOT NULL,
    numero_studenti INT(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  
  $conn->exec($createTableSQL);

  // Inizio della transazione per l'inserimento delle nuove materie
  $conn->beginTransaction();

  // Inserisco nuove materie solo se non esistono già
  $nuoveMaterie = [
    ["Arte", 50],
    ["Geografia", 15],
    ["Diritto", 45]
  ];

  foreach ($nuoveMaterie as $materia) {
    $nomeMateria = $materia[0];
    $numeroStudenti = $materia[1];

    // Verifica se la materia esiste già
    $stmt = $conn->prepare("SELECT id FROM Corsi WHERE nome_corso = :nomeMateria");
    $stmt->bindParam(':nomeMateria', $nomeMateria);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      // La materia non esiste, quindi la inseriamo
      $sql = "INSERT INTO Corsi (nome_corso, numero_studenti) VALUES (:nomeMateria, :numeroStudenti)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':nomeMateria', $nomeMateria);
      $stmt->bindParam(':numeroStudenti', $numeroStudenti);
      $stmt->execute();
    }
  }

  // Conferma la transazione
  $conn->commit();
  echo "Nuove materie inserite con successo";
} catch(PDOException $e) {
  // Rollback della transazione in caso di errore
  $conn->rollback();
  echo "Errore durante l'inserimento dei dati: " . $e->getMessage();
}

$conn = null;
?>
