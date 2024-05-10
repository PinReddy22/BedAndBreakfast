<?php
require_once('config.php');
session_start();
$idCliente=$_SESSION['idCliente'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le tue prenotazioni</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .table-container {
            max-height: 400px; 
            overflow-y: auto; 
            overflow-x: hidden; 
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
    <h1 class="absolute top-0 text-3xl font-semibold text-center text-gray-700 w-full">Le tue prenotazioni</h1>
    <div class="relative flex flex-col items-center justify-center p-6 bg-white border-t-4 border-gray-600 rounded-md shadow-md border-top">

        <div class="table-container">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID Prenotazione
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Data Inizio
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Data Fine
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Conferma Pagamento
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nome Camera
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Recensione
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Elimina
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $sql = "SELECT idPrenotazione, data_inizio, data_fine, conferma_pagamento, Camere.nome
                    FROM Prenotazioni
                    JOIN Camere ON Prenotazioni.idCamera = Camere.idCamera
                    WHERE idCliente = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("i", $idCliente);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row['idPrenotazione'] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row['data_inizio'] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row['data_fine'] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . ($row['conferma_pagamento'] ? 'Pagato' : 'Non Pagato') . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row['nome'] . "</td>";
                        echo '<td class="px-6 py-4 whitespace-nowrap">';
                        echo '<button class="text-blue-500 hover:underline" onclick="openReviewModal(' . $row['idPrenotazione'] . ')">Recensione</button>';
                        echo '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">';
                        echo '<form action="elimina_prenotazione.php" method="POST">';
                        echo '<input type="hidden" name="idPrenotazione" value="' . $row['idPrenotazione'] . '">';
                        echo '<button type="submit" class="text-red-600 hover:text-red-900">Elimina</button>';
                        echo '</form>';
                        echo '</td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<dialog id="reviewModal" class="modal">
    <div class="modal-box p-6 bg-white rounded-md shadow-lg">
        <h3 class="font-bold text-lg mb-4">Lascia una Recensione</h3>
        <form id="reviewForm" method="POST" action="invia_recensione.php">
            <input type="hidden" id="prenotazioneId" name="idPrenotazione">
            <div class="mb-4">
                <label for="voto" class="block mb-1">Voto:</label>
                <input type="number" id="voto" name="voto" min="1" max="5" required class="border rounded-md px-3 py-2 w-full" />
            </div>
            <div class="mb-4">
                <label for="commento" class="block mb-1">Commento:</label>
                <textarea id="commento" name="commento" required class="border rounded-md px-3 py-2 w-full"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Invia Recensione</button>
            </div>
        </form>
        <div class="flex justify-end">
        <button onclick="closeReviewModal()" class="mt-4 bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Chiudi</button>
        </div>
    </div>
</dialog>


<script>
    function openReviewModal(idPrenotazione) {
        document.getElementById('prenotazioneId').value = idPrenotazione;
        var reviewModal = document.getElementById('reviewModal');
        reviewModal.showModal();
    }

    function closeReviewModal() {
        var reviewModal = document.getElementById('reviewModal');
        reviewModal.close();
    }
</script>

<footer class="footer grid-rows-2 p-5 bg-neutral text-neutral-content">
    © 2024 Bed and Breakfast. Tutti i diritti riservati.
    <a href="logout.php" class="text-white hover:text-gray-300 underline" >LogOut</button>

</footer>
</body>
</html>
