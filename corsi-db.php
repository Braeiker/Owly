<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "Owly_Database"; 

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Dati per i corsi
  $corsi = [
    ["Matematica", 50],
    ["Storia", 40],
    ["Scienze", 60],
    ["Informatica", 50],
    ["Inglese", 100],
  ];

  // Inserimento dei dati
  foreach ($corsi as $corso) {
    $nomeCorso = $corso[0];
    $numeroStudenti = $corso[1];

    $sql = "INSERT INTO Corsi (nome_corso, numero_studenti) VALUES (:nomeCorso, :numeroStudenti)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nomeCorso', $nomeCorso);
    $stmt->bindParam(':numeroStudenti', $numeroStudenti);

    $stmt->execute();
  }

  echo "Dati inseriti con successo.";
} catch(PDOException $e) {
  echo "Errore durante l'inserimento dei dati: " . $e->getMessage();
}

$conn = null;
?>
