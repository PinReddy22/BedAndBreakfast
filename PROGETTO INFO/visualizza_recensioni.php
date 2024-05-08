<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni della Camera</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Stile per la visualizzazione delle recensioni */
        .review-container {
            max-width: 800px; /* Larghezza massima */
            margin: 0 auto; /* Centra il contenuto */
            padding: 20px; /* Spaziatura interna */
            border: 1px solid #ccc; /* Bordo */
            border-radius: 8px; /* Bordi arrotondati */
            background-color: #fff; /* Colore di sfondo */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ombra */
        }

        .review {
            margin-bottom: 20px; /* Spaziatura tra le recensioni */
            padding: 10px; /* Spaziatura interna */
            border: 1px solid #ddd; /* Bordo */
            border-radius: 8px; /* Bordi arrotondati */
            background-color: #f9f9f9; /* Colore di sfondo */
        }

        .review p {
            margin: 0; /* Rimuove il margine di default */
            padding: 0; /* Rimuove la spaziatura interna di default */
        }
    </style>
</head>
<body class="h-screen flex flex-col">
<header class="p-5 bg-neutral text-neutral-content">
    <div class="flex flex-col items-center justify-center space-y-4">
        <h1 class="text-3xl font-semibold text-white">Bed and Breakfast</h1>
        <nav class="flex space-x-4">
            <a href="index.php" class="text-white hover:text-gray-300">Prenota Camera</a>
            <a href="visualizza_camere.php" class="text-white hover:text-gray-300">Visualizza Camere</a>
        </nav>
    </div>
</header>

<div class="flex-grow relative flex flex-col items-center justify-center overflow-hidden">
    <h1 class="absolute top-0 text-3xl font-semibold text-center text-gray-700 w-full">Recensioni della Camera</h1>
    <div class="review-container">
        <?php
        require_once('config.php');
        session_start();
        $idCliente = $_SESSION['idCliente'];

        // Verifichiamo se è stato passato l'ID della camera tramite URL
        if(isset($_GET['idCamera'])) {
            $idCamera = $_GET['idCamera'];

            // Query per selezionare le recensioni relative alla camera specificata
            $sql = "SELECT r.idRecensione, r.voto, r.testo, c.nome AS nomeCliente
                    FROM Recensioni r
                    INNER JOIN Prenotazioni p ON r.idPrenotazione = p.idPrenotazione
                    INNER JOIN Clienti c ON p.idCliente = c.idCliente
                    WHERE p.idCamera = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $idCamera);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifichiamo se ci sono recensioni per questa camera
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Visualizziamo le recensioni
                    echo "<div class='review'>";
                    echo "<p>Cliente: {$row['nomeCliente']}</p>";
                    echo "<p>Voto: {$row['voto']}</p>";
                    echo "<p>Recensione: {$row['testo']}</p>";
                    echo "</div>";
                }
            } else {
                echo "Nessuna recensione disponibile per questa camera.";
            }

            // Chiudiamo lo statement e la connessione al database
            $stmt->close();
            $db->close();
        } else {
            echo "ID della camera non fornito.";
        }
        ?>
    </div>
</div>
<footer class="footer grid-rows-2 p-5 bg-neutral text-neutral-content">
    © 2024 Bed and Breakfast. Tutti i diritti riservati.
</footer>
</body>
</html>
