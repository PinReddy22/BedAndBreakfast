<?php
require_once('config.php');

// Controlla se sono stati inviati i dati del modulo
if(isset($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_POST['capacita'])) {
    // Prendi i dati dal modulo
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $prezzo = $_POST['prezzo'];
    $capacita = $_POST['capacita'];
    
    // Query per l'inserimento della camera
    $sql = "INSERT INTO Camere (nome, descrizione, prezzo, capacita) VALUES (?, ?, ?, ?)";
    
    // Prepara la query
    $stmt = $db->prepare($sql);
    
    // Collega i parametri e esegui la query
    $stmt->bind_param("ssdi", $nome, $descrizione, $prezzo, $capacita);
    $stmt->execute();
    
    // Chiudi lo statement e la connessione al database
    $stmt->close();
    $db->close();
    
    // Reindirizza alla pagina delle camere dopo l'inserimento
    header("Location: visualizza_camereAdmin.php?success=Camera+aggiunta+con+successo");
    exit();
} else {
    // Se non sono stati inviati tutti i dati del modulo, reindirizza alla pagina delle camere
    header("Location: visualizza_camereAdmin.php");
    exit();
}
?>
