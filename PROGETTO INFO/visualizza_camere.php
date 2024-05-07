<?php
require_once('config.php');
session_start();
$idCliente = $_SESSION['idCliente'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .card.card-compact {
        width: 400px; 
        height: 400px;
    }
</style>
</head>
<body class="h-screen flex flex-col">
<header class="p-5 bg-neutral text-neutral-content">
    <div class="flex flex-col items-center justify-center space-y-4">
        <h1 class="text-3xl font-semibold text-white">Bed and Breakfast</h1>
        
        <nav class="flex space-x-4">
            <a href="visualizza_prenotazioni.php" class="text-white hover:text-gray-300">Visualizza Prenotazioni</a>
            <a href="visualizza_prenotazioni.php" class="text-white hover:text-gray-300">Visualizza Prenotazioni</a>
        </nav>
    </div>
</header>

<div class="relative flex flex-col items-center justify-center p-6 bg-white border-t-4 border-gray-600 rounded-md shadow-md border-top card-container">

    
    <div class="relative flex flex-col items-center justify-center p-6 bg-white border-t-4 border-gray-600 rounded-md shadow-md border-top">
        <h1 class="text-3xl font-semibold text-center text-gray-700">Visualizza le Camere</h1>
        
        <?php

// Query per selezionare tutte le camere
$sql = "SELECT * FROM Camere";
$result = $db->query($sql);

// Inizia la visualizzazione delle camere
if ($result->num_rows > 0) {
    // Loop attraverso ogni riga risultante
    $count = 0; // Contatore per verificare ogni 3 camere
    while ($row = $result->fetch_assoc()) {
        // Se è il primo elemento o un multiplo di 3, apri un nuovo div di riga
        if ($count == 0 || $count % 3 == 0) {
            echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">';
        }
        
        // Visualizza la camera
        echo '<div class="card card-compact bg-base-100 shadow-xl">';
        echo '<div class="card-body">';
        echo '<img src="https://www.blunottefirenze.com/Filtrate/img_2455.jpg" alt="Immagine Camera" class="h-40 w-full object-cover">';
        echo '<h2 class="card-title">' . $row['nome'] . '</h2>';
        echo '<p>' . $row['descrizione'] . '</p>';
        echo '<p>Prezzo: €' . $row['prezzo'] . '</p>';
        echo '<p>Capacità: ' . $row['capacita'] . ' persone</p>';
        // Aggiungi il pulsante per vedere le recensioni
        echo '<a href="recensioni.php?idCamera=' . $row['idCamera'] . '" class="btn btn-primary">Vedi Recensioni</a>';
        echo '</div>';
        echo '</div>';
        
        $count++; // Incrementa il contatore
        
        // Se è l'ultimo elemento della riga o l'ultimo elemento, chiudi il div di riga
        if ($count % 3 == 0 || $count == $result->num_rows) {
            echo '</div>'; // Chiudi il div di riga
            echo '<br>';
        }
    }
} else {
    echo "Nessuna camera disponibile al momento.";
}
?>



    </div>
</div>
<footer class="footer grid-rows-2 p-5 bg-neutral text-neutral-content">
    © 2024 Bed and Breakfast. Tutti i diritti riservati.
</footer>
</body>
</html>
