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
</head>
<body class="h-screen flex flex-col">
<header class="p-5 bg-neutral text-neutral-content">
    <div class="flex flex-col items-center justify-center space-y-4">
        <h1 class="text-3xl font-semibold text-white">Bed and Breakfast</h1>
        <nav class="flex space-x-4">
            <a href="visualizza_prenotazioni.php" class="text-white hover:text-gray-300">Visualizza Prenotazioni</a>
            <a href="visualizza_camere.php" class="text-white hover:text-gray-300">Visualizza Camere</a>
        </nav>
        <!-- Pulsante per il logout -->
        <!-- Fine del pulsante per il logout -->
    </div>
</header>

<div class="flex-grow relative flex flex-col items-center justify-center overflow-hidden">
    <h1 class="absolute top-0 text-3xl font-semibold text-center text-gray-700 w-full">Prenota la tua Camera</h1>
    <div class="w-full p-6 bg-white border-t-4 border-gray-600 rounded-md shadow-md border-top lg:max-w-lg">
        <!-- Aggiunta della sezione per visualizzare l'esito della prenotazione -->
        <?php
        // Verifica se è presente un messaggio di errore o di successo nell'URL
        if (isset($_GET['error'])) {
            echo '<div id="alertMessage" class="alert alert-error w-full">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            echo '<span>' . $_GET['error'] . '</span>';
            echo '</div>';
        } elseif (isset($_GET['success'])) {
            echo '<div id="alertMessage" class="alert alert-success w-full">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            echo '<span>' . $_GET['success'] . '</span>';
            echo '</div>';
        }
        ?>
        <!-- Fine della sezione per visualizzare l'esito della prenotazione -->
        <h1 class="text-3xl font-semibold text-center text-gray-700">Prenota una camera</h1>
        <form class="space-y-4" action="prenotazione_process.php" method="POST">
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="label">
                        <span class="text-base label-text">Camera</span>
                    </label>
                    <select name="camera" class="input input-bordered w-full" required>
                        <option value="" disabled selected>Seleziona una camera</option>
                        <?php
                        require_once('config.php');

                        // Query per selezionare i nomi delle camere
                        $sql = "SELECT nome FROM Camere";

                        // Esegui la query
                        $stmt = $db->prepare($sql);
                        $stmt->execute();

                        // Associa il risultato della query
                        $stmt->bind_result($nomeCamera);

                        // Genera le opzioni per il menu a discesa
                        while ($stmt->fetch()) {
                            echo '<option value="' . $nomeCamera . '">' . $nomeCamera . '</option>';
                        }

                        // Chiudi lo statement e la connessione al database
                        $stmt->close();
                        $db->close();
                        ?>
                    </select>
                </div>
                <div class="w-1/4">
                    <label class="label">
                        <span class="text-base label-text">Check-in</span>
                    </label>
                    <input type="date" name="data_checkin" class="input input-bordered w-full" required />
                </div>
                <div class="w-1/4">
                    <label class="label">
                        <span class="text-base label-text">Check-out</span>
                    </label>
                    <input type="date" name="data_checkout" class="input input-bordered w-full" required />
                </div>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="submit" class="btn btn-primary">Cerca</button>
            </div>
        </form>
    </div>
</div>
<footer class="footer grid-rows-2 p-5 bg-neutral text-neutral-content">
    © 2024 Bed and Breakfast. Tutti i diritti riservati.
    <?php echo $idCliente; ?>
</footer>
<script>
    // Nasconde l'alert dopo 5 secondi
    setTimeout(() => {
        document.getElementById('alertMessage').style.display = 'none';
    }, 4000);
</script>
</body>
</html>
