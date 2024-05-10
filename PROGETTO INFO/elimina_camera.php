<?php
require_once('config.php');

if(isset($_POST['idCamera'])) {
    $idCamera = $_POST['idCamera'];
    $sql = "DELETE from camere where idCamera=?";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bind_param("i", $idCamera);
    $stmt->execute();
    
    $stmt->close();
    $db->close();
    
    header("Location: visualizza_camereAdmin.php");
    exit();
} else {
    header("Location: visualizza_CamereAdmin.php");
    exit();
}
?>
