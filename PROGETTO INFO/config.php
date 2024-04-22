<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bedandbreakfast";

// Crea una connessione
$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connessione al database fallita: " . $db->connect_error);
}
  
?>