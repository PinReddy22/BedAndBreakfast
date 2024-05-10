<?php
require_once('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $camera = $_POST['camera'];
    $data_checkin = $_POST['data_checkin'];
    $data_checkout = $_POST['data_checkout'];

    $idCliente = $_SESSION['idCliente'];

    $sql = "SELECT idPrenotazione
                          FROM Prenotazioni
                          WHERE idCamera = ?
                          AND ((STR_TO_DATE(?, '%Y-%m-%d') BETWEEN data_inizio AND data_fine)
                          OR (STR_TO_DATE(?, '%Y-%m-%d') BETWEEN data_inizio AND data_fine)
                          OR (data_inizio BETWEEN STR_TO_DATE(?, '%Y-%m-%d') AND STR_TO_DATE(?, '%Y-%m-%d'))
                          OR (data_fine BETWEEN STR_TO_DATE(?, '%Y-%m-%d') AND STR_TO_DATE(?, '%Y-%m-%d')))
                          LIMIT 1";

    $stmt = $db->prepare($sql);

    $query_camera = "SELECT idCamera FROM camere WHERE nome = ?";
    $stmt_camera = $db->prepare($query_camera);
    $stmt_camera->bind_param("s", $camera);
    $stmt_camera->execute();
    $result_camera = $stmt_camera->get_result();
    $row_camera = $result_camera->fetch_assoc();
    $idCamera = $row_camera['idCamera'];

    $stmt->bind_param("issssss", $idCamera, $data_checkin, $data_checkout, $data_checkin, $data_checkout, $data_checkin, $data_checkout);

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    if ($result->num_rows > 0) {
        header("Location: index.php?error=La+camera+è+già+occupata+per+le+date+specificate.");
        exit();
    } else {

        $sql_insert = "INSERT INTO Prenotazioni (data_inizio, data_fine, conferma_pagamento, idCliente, idCamera) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $db->prepare($sql_insert);
        $conferma_pagamento = false; // Puoi impostare il valore di conferma_pagamento in base alle tue esigenze
        $stmt_insert->bind_param("ssiii", $data_checkin, $data_checkout, $conferma_pagamento, $idCliente, $idCamera);
        $stmt_insert->execute();

        $stmt_insert->close();

        header("Location: index.php?success=Prenotazione+aggiunta+con+successo!");
        exit();
    }
}
?>
