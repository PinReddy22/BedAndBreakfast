<?php
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni della Camera</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .review-container {
            max-width: 800px;
            margin: 0 auto; 
            padding: 20px; 
            border: 1px solid #ccc; 
            border-radius: 8px;
            background-color: #fff; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
            overflow-y: auto; 
        }

        .review-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px; 
        }

        .review {
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            background-color: #f9f9f9; 
        }

        .review p {
            margin: 0; 
            padding: 0; 
        }
    </style>
</head>
<body class="h-screen flex flex-col">
<header class="p-5 bg-neutral text-neutral-content">
    <div class="flex flex-col items-center justify-center space-y-4">
        <h1 class="text-3xl font-semibold text-white">Bed and Breakfast</h1>
        <nav class="flex space-x-4">
            <a href="indexAdmin.php" class="text-white hover:text-gray-300">Prenota Camera</a>
            <a href="visualizza_camereAdmin.php" class="text-white hover:text-gray-300">Visualizza Camere</a>
        </nav>
    </div>
</header>

<div class="flex-grow relative flex flex-col items-center justify-center overflow-hidden">
    <h1 class="absolute top-0 text-3xl font-semibold text-center text-gray-700 w-full">Recensioni della Camera</h1>
    <div class="review-container">
        <div class="review-grid">
            <?php
            if(isset($_GET['idCamera'])) {
                $idCamera = $_GET['idCamera'];

                $sql = "SELECT r.idRecensione, r.voto, r.testo, c.nome AS nomeCliente
                        FROM Recensioni r
                        INNER JOIN Prenotazioni p ON r.idPrenotazione = p.idPrenotazione
                        INNER JOIN Clienti c ON p.idCliente = c.idCliente
                        WHERE p.idCamera = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("i", $idCamera);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='review'>";
                        echo "<p>Cliente: {$row['nomeCliente']}</p>";
                        echo "<p>Voto: {$row['voto']}</p>";
                        echo "<p>Recensione: {$row['testo']}</p>";
                        echo '<form action="elimina_recensione.php" method="POST" class="mt-4">';
                        echo '<input type="hidden" name="idRecensione" value="' . $row['idRecensione'] . '">';
                        echo '<input type="hidden" name="idCamera" value="' . $idCamera . '">';
                        echo '<button type="submit" class="btn btn-danger w-full">Elimina</button>';
                        echo '</form>';
                        echo "</div>";
                    }
                } else {
                    echo "Nessuna recensione disponibile per questa camera.";
                }

                $stmt->close();
            } else {
                echo "ID della camera non fornito.";
            }
            ?>
        </div>
    </div>
</div>
<footer class="footer grid-rows-2 p-5 bg-neutral text-neutral-content">
    © 2024 Bed and Breakfast. Tutti i diritti riservati.
    <a href="logout.php" class="text-white hover:text-gray-300 underline" >LogOut</button>

</footer>
</body>
</html>
