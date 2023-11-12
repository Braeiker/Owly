<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Creazione del database
  $sql = "CREATE DATABASE IF NOT EXISTS owly_db";

  // Controllo della connessione
  $conn->exec($sql);
  echo "Database created successfully<br>";

  // Connessione al database
  $conn = new PDO("mysql:host=$servername;dbname=owly_db", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo "Connected to database successfully<br>";

  // Chiudi la connessione al database
  $conn = null;

} catch (PDOException $e) {
  echo "Errore: " . $e->getMessage();
}

?>
