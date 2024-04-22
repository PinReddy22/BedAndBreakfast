<?php
require_once('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera l'email e la password inviate dal form di login
    $email = $_POST['email'];
    $password = ($_POST['password']);

    // Query per recuperare l'utente con l'email fornita
    echo $email." ".$password;
    $sql = "SELECT * FROM clienti WHERE mail = ? AND password=? LIMIT 1";
    $insert = $db->prepare($sql);
    $risultato=$insert->execute([$email,$password]);
    if($risultato){
        $utente = $insert->fetch();
        echo "sono in risultato";
        echo $risultato;
        echo "stop risultato";
        print_r($utente); // Stampare eventuali risultati della query per debug
        if($insert->num_rows > 0){
            echo "sono in insert  ";
            header("Location: index.php");
            exit();
        } else {
            // Credenziali non valide
            $error_message = "Credenziali non valide";
        }
    }
    }

?>