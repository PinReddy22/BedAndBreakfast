<?php
require_once('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati inviati dal form
    $camera = $_POST['camera'];
    $data_checkin = $_POST['data_checkin'];
    $data_checkout = $_POST['data_checkout'];

    // Recupera l'idCliente dalla sessione
    $idCliente = $_SESSION['idCliente'];

    // Query per verificare se ci sono prenotazioni sovrapposte per la stessa camera
    $sql_check_overlap = "SELECT idPrenotazione
                          FROM Prenotazioni
                          WHERE idCamera = ?
                          AND ((STR_TO_DATE(?, '%Y-%m-%d') BETWEEN data_inizio AND data_fine)
                          OR (STR_TO_DATE(?, '%Y-%m-%d') BETWEEN data_inizio AND data_fine)
                          OR (data_inizio BETWEEN STR_TO_DATE(?, '%Y-%m-%d') AND STR_TO_DATE(?, '%Y-%m-%d'))
                          OR (data_fine BETWEEN STR_TO_DATE(?, '%Y-%m-%d') AND STR_TO_DATE(?, '%Y-%m-%d')))
                          LIMIT 1";

    // Prepara la query per verificare sovrapposizioni
    $stmt_check_overlap = $db->prepare($sql_check_overlap);

    // Recupera l'id della camera
    $query_camera = "SELECT idCamera FROM camere WHERE nome = ?";
    $stmt_camera = $db->prepare($query_camera);
    $stmt_camera->bind_param("s", $camera);
    $stmt_camera->execute();
    $result_camera = $stmt_camera->get_result();
    $row_camera = $result_camera->fetch_assoc();
    $idCamera = $row_camera['idCamera'];

    // Associa i valori ai parametri per la query di verifica sovrapposizione
    $stmt_check_overlap->bind_param("issssss", $idCamera, $data_checkin, $data_checkout, $data_checkin, $data_checkout, $data_checkin, $data_checkout);

    // Esegui la query per verificare sovrapposizioni
    $stmt_check_overlap->execute();

    // Ottieni il risultato della query per verificare sovrapposizioni
    $result_overlap = $stmt_check_overlap->get_result();

    // Chiudi lo statement per verificare sovrapposizioni
    $stmt_check_overlap->close();

    // Se esiste già una prenotazione sovrapposta, reindirizza alla pagina index.php con un messaggio di errore
    if ($result_overlap->num_rows > 0) {
        header("Location: index.php?error=La+camera+è+già+occupata+per+le+date+specificate.");
        exit();
    } else {
        // Altrimenti, aggiungi la nuova prenotazione al database

        // Query per inserire la nuova prenotazione nel database
        $sql_insert = "INSERT INTO Prenotazioni (data_inizio, data_fine, conferma_pagamento, idCliente, idCamera) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $db->prepare($sql_insert);
        $conferma_pagamento = false; // Puoi impostare il valore di conferma_pagamento in base alle tue esigenze
        $stmt_insert->bind_param("ssiii", $data_checkin, $data_checkout, $conferma_pagamento, $idCliente, $idCamera);
        $stmt_insert->execute();

        // Chiudi lo statement per l'inserimento della prenotazione
        $stmt_insert->close();

        // Reindirizza alla pagina index.php con un messaggio di successo
        header("Location: index.php?success=Prenotazione+aggiunta+con+successo!");
        exit();
    }
}
?>
