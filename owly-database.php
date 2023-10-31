<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Creazione del database
  $sql = "CREATE DATABASE IF NOT EXISTS Owly_Database";

  // Controllo della connessione
  $conn->exec($sql);
  echo "Database created successfully<br>";

  // Ora connettiamoci al database appena creato
  $conn = new PDO("mysql:host=$servername;dbname=Owly_Database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Creazione della tabella
  $sql = "CREATE TABLE Corsi (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_corso VARCHAR(30) NOT NULL,
    numero_studenti INT(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  $conn->exec($sql);
  echo "Table 'Corsi' created successfully<br>";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
