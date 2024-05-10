<?php

require_once('config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = ($_POST['password']);

    $sql = "SELECT idCliente,mail,password,admin FROM `clienti` WHERE mail=? and password=? LIMIT 1";
    $insert = $db->prepare($sql);
    $insert->bind_param("ss",$email,$password);
    $insert->execute();
    $risultato = $insert->get_result();
    if($risultato->num_rows >0){
        $utente= array($risultato->fetch_assoc());
        if($utente[0]['admin']==1){
            header("location: indexAdmin.php");
        }else{
        print_r($utente); 
        $id = $utente[0]['idCliente'];
            session_start();
            $_SESSION['idCliente'] = $id;
            header("Location: index.php");
            exit();
        }
        } else {
            header("Location: login.php?error=Email+o+Password+Errati. Reinserire+le+credenziali.");

            exit();
    }
    }

?>