<?php
require_once('config.php');
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
        height: 500px;
    }
</style>
</head>
<body class="h-screen flex flex-col">
<header class="p-5 bg-neutral text-neutral-content">
    <div class="flex flex-col items-center justify-center space-y-4">
        <h1 class="text-3xl font-semibold text-white">Bed and Breakfast</h1>
        
        <nav class="flex space-x-4">
            <a href="indexAdmin.php" class="text-white hover:text-gray-300">Prenota Camera</a>
            <a href="visualizza_prenotazioniAdmin.php" class="text-white hover:text-gray-300">Visualizza Prenotazioni</a>
        </nav>
    </div>
</header>
<!-- Modal per aggiungere una nuova camera -->
<dialog id="addRoomModal" class="modal">
  <div class="modal-box w-11/12 max-w-5xl">
    <h3 class="font-bold text-lg">Aggiungi una Nuova Camera</h3>
    <form action="aggiungi_camera.php" method="POST" class="py-4">
      <div class="form-control">
        <label for="nome" class="block text-sm font-medium text-gray-700">Nome Camera:</label>
        <input type="text" id="nome" name="nome" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100">
      </div>
      <div class="form-control">
        <label for="descrizione" class="block text-sm font-medium text-gray-700">Descrizione:</label>
        <textarea id="descrizione" name="descrizione" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100"></textarea>
      </div>
      <div class="form-control">
        <label for="prezzo" class="block text-sm font-medium text-gray-700">Prezzo (€):</label>
        <input type="number" id="prezzo" name="prezzo" step="0.01" min="0" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100">
      </div>
      <div class="form-control">
        <label for="capacita" class="block text-sm font-medium text-gray-700">Capacità:</label>
        <input type="number" id="capacita" name="capacita" min="1" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100">
      </div>
      <div class="modal-action mt-4">
        <button type="submit" class="btn btn-primary">Aggiungi Camera</button>
        <button class="btn" onclick="closeAddRoomModal()">Annulla</button>
      </div>
    </form>
  </div>
</dialog>


<!-- Aggiungi un pulsante per aprire il modale -->
<div class="flex items-center justify-center">
    <p class="text-center text-blue-500 cursor-pointer font-semibold hover:underline" onclick="openAddRoomModal()">Aggiungi Camera</p>
</div>
    

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
        echo '<a href="visualizza_recensioni.php?idCamera=' . $row['idCamera'] . '" class="btn btn-primary">Visualizza recensioni</a>';
        // Modifica il pulsante Elimina
        echo '<form action="elimina_camera.php" method="POST" class="mt-4">';
        echo '<input type="hidden" name="idCamera" value="' . $row['idCamera'] . '">';
        echo '<button type="submit" class="btn btn-danger w-full">Elimina</button>';
        echo '</form>';
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
    <a href="logout.php" class="text-white hover:text-gray-300 underline" >LogOut</button>

</footer>
<script>
  // Funzione per aprire il modale per aggiungere una nuova camera
  function openAddRoomModal() {
    var addRoomModal = document.getElementById('addRoomModal');
    addRoomModal.showModal();
  }

  // Funzione per chiudere il modale per aggiungere una nuova camera
  function closeAddRoomModal() {
    var addRoomModal = document.getElementById('addRoomModal');
    addRoomModal.close();
  }
</script>
</body>
</html>
