<?php
require_once('config.php');

if(isset($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_POST['capacita'])) {
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $prezzo = $_POST['prezzo'];
    $capacita = $_POST['capacita'];
    
    $sql = "INSERT INTO Camere (nome, descrizione, prezzo, capacita) VALUES (?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bind_param("ssdi", $nome, $descrizione, $prezzo, $capacita);
    $stmt->execute();
    
    $stmt->close();
    $db->close();
    
    header("Location: visualizza_camereAdmin.php?success=Camera+aggiunta+con+successo");
    exit();
} else {
    header("Location: visualizza_camereAdmin.php");
    exit();
}
?>
