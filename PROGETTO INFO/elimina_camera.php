<?php
require_once('config.php');

// Controlla se è stato inviato un ID di prenotazione
if(isset($_POST['idCamera'])) {
    // Prendi l'ID della prenotazione dall'input del form
    $idCamera = $_POST['idCamera'];
    // Query per eliminare la prenotazione
    $sql = "DELETE from camere where idCamera=?";
    
    // Prepara la query
    $stmt = $db->prepare($sql);
    
    // Collega i parametri e esegui la query
    $stmt->bind_param("i", $idCamera);
    $stmt->execute();
    
    // Chiudi lo statement e la connessione al database
    $stmt->close();
    $db->close();
    
    // Reindirizza alla pagina delle prenotazioni dopo l'eliminazione
    header("Location: visualizza_camereAdmin.php");
    exit();
} else {
    // Se non è stato inviato alcun ID di prenotazione, reindirizza alla pagina delle prenotazioni
    header("Location: visualizza_CamereAdmin.php");
    exit();
}
?>
