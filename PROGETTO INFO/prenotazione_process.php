<?php
require_once('config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera l'email e la password inviate dal form di login
    $email = $_POST['email'];
    $password = ($_POST['password']);

    // Query per recuperare l'utente con l'email fornita
    $sql = "INSERT INTO prenotazioni (nome, descrizione, prezzo, capacita) VALUES ()
    ";
    $insert = $db->prepare($sql);
    $insert->bind_param("ss",$email,$password);
    $insert->execute();

}
?>