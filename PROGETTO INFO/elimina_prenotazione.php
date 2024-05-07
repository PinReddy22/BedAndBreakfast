<?php
require_once('config.php');

// Controlla se è stato inviato un ID di prenotazione
if(isset($_POST['idPrenotazione'])) {
    // Prendi l'ID della prenotazione dall'input del form
    $idPrenotazione = $_POST['idPrenotazione'];

    // Query per eliminare la prenotazione
    $sql = "DELETE FROM Prenotazioni WHERE idPrenotazione = ?";
    
    // Prepara la query
    $stmt = $db->prepare($sql);
    
    // Collega i parametri e esegui la query
    $stmt->bind_param("i", $idPrenotazione);
    $stmt->execute();
    
    // Chiudi lo statement e la connessione al database
    $stmt->close();
    $db->close();
    
    // Reindirizza alla pagina delle prenotazioni dopo l'eliminazione
    header("Location: visualizza_prenotazioni.php");
    exit();
} else {
    // Se non è stato inviato alcun ID di prenotazione, reindirizza alla pagina delle prenotazioni
    header("Location: visualizza_prenotazioni.php");
    exit();
}
?>
