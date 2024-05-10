<?php
require_once('config.php');

if(isset($_POST['idRecensione'], $_POST['idCamera'])) {
    $idRecensione = $_POST['idRecensione'];
    $idCamera = $_POST['idCamera'];
    $sql = "DELETE FROM Recensioni WHERE idRecensione = ?";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bind_param("i", $idRecensione);
    $stmt->execute();
    
    $stmt->close();
    
    header("Location: visualizza_recensioniAdmin.php?idCamera=" . $idCamera);
    exit();
} else {
    header("Location: visualizza_recensioniAdmin.php");
    exit();
}
?>
