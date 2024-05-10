<?php
require_once('config.php');

if(isset($_POST['idPrenotazione'])) {
    $idPrenotazione = $_POST['idPrenotazione'];
    $voto=$_POST['voto'];
    $commento=$_POST['commento'];
    $sql = "INSERT INTO recensioni (idPrenotazione,voto,testo) values (?,?,?);";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bind_param("iis", $idPrenotazione,$voto,$commento);
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
