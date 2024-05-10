<?php
require_once('config.php');
    
$imagePath = 'C:\Users\fahri\OneDrive\Desktop\img_2455.jpg';

$imageData = file_get_contents($imagePath);

$escapedImageData = $db->real_escape_string($imageData);



$updateQuery = "UPDATE Camere SET foto = '{$escapedImageData}' ";

$result = $db->query($updateQuery);

if ($result) {
    echo "Immagine caricata con successo.";
} else {
    echo "Errore durante il caricamento dell'immagine.";
}

$db->close();
?>
