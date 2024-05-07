<?php

require_once('config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera l'email e la password inviate dal form di login
    $email = $_POST['email'];
    $password = ($_POST['password']);

    // Query per recuperare l'utente con l'email fornita
    $sql = "SELECT idCliente,mail,password FROM `clienti` WHERE mail=? and password=? LIMIT 1";
    $insert = $db->prepare($sql);
    $insert->bind_param("ss",$email,$password);
    $insert->execute();
    $risultato = $insert->get_result();
    if($risultato->num_rows >0){
        $utente= array($risultato->fetch_assoc());
        echo "sono in risultato";
        echo "stop risultato";
        print_r($utente); // Stampare eventuali risultati della query per debug
        $id = $utente[0]['idCliente'];
            echo "sono in insert  ";
            session_start();
            $_SESSION['idCliente'] = $id;
            header("Location: index.php");
            exit();
        
        } else {
            // Credenziali non valide
            header("Location: login.php?error=Email+o+Password+Errati. Reinserire+le+credenziali.");

            exit();
    }
    }

?>