<?php
require_once('config.php');

if(isset($_POST['idPrenotazione'])) {
    $idPrenotazione = $_POST['idPrenotazione'];

    $sql = "DELETE FROM Prenotazioni WHERE idPrenotazione = ?";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bind_param("i", $idPrenotazione);
    $stmt->execute();
    
    $stmt->close();
    $db->close();
    
    header("Location: visualizza_prenotazioni.php");
    exit();
} else {
    header("Location: visualizza_prenotazioni.php");
    exit();
}
?>
