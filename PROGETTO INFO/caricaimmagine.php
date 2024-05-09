<?php
// Connessione al database
require_once('config.php');
    
// Percorso dell'immagine da caricare
$imagePath = 'C:\Users\fahri\OneDrive\Desktop\img_2455.jpg';

// Leggi il contenuto dell'immagine
$imageData = file_get_contents($imagePath);

// Escaping per evitare SQL injection (opzionale)
$escapedImageData = $db->real_escape_string($imageData);

// ID della camera a cui associare l'immagine (supponiamo che tu abbia questa informazione)


// Query per aggiornare la colonna foto della camera specificata
$updateQuery = "UPDATE Camere SET foto = '{$escapedImageData}' ";

// Esegui la query di aggiornamento
$result = $db->query($updateQuery);

// Verifica se l'aggiornamento è stato eseguito con successo
if ($result) {
    echo "Immagine caricata con successo.";
} else {
    echo "Errore durante il caricamento dell'immagine.";
}

// Chiudi la connessione al database
$db->close();
?>
