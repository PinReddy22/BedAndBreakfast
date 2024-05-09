<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bed And Breakfast</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = ($_POST['password']) ;
    $sql="INSERT INTO clienti (nome, cognome, mail, password) VALUES (?, ?, ?, ?)" ;
    $insert = $db->prepare($sql);
    $risultato=$insert->execute([$nome,$cognome,$email,$password]);
    
}
?>


<div class="relative flex flex-col items-center justify-center h-screen overflow-hidden">
    <h1 class="text-3xl font-semibold text-center text-gray-700 mb-4">Bed and Breakfast</h1>
    <div class="w-full p-6 bg-white border-t-4 border-gray-600 rounded-md shadow-md border-top lg:max-w-lg">
        <h1 class="text-3xl font-semibold text-center text-gray-700">Registrati</h1>
        <form class="space-y-4" action="register.php" method="POST">
            <div>
                <label class="label">
                    <span class="text-base label-text">Nome</span>
                </label>
                <input type="text" name="nome" placeholder="Nome" class="w-full input input-bordered input-lg" required/>
            </div>
            <div>
                <label class="label">
                    <span class="text-base label-text">Cognome</span>
                </label>
                <input type="text" name="cognome" placeholder="Cognome" class="w-full input input-bordered input-lg"  required/>
            </div>
            <div>
                <label class="label">
                    <span class="text-base label-text">Email</span>
                </label>
                <input type="text" name="email" placeholder="Email Address" class="w-full input input-bordered input-lg" required/>
            </div>
            <div>
                <label class="label">
                    <span class="text-base label-text">Password</span>
                </label>
                <input type="password" name="password" placeholder="Enter Password" class="w-full input input-bordered input-lg" required/>
            </div>
            
            <div>
                <button type="submit" class="btn btn-block">Registrati</button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <span>Sei già registrato?</span>
            <a href="login.php" class="text-indigo-600 font-bold">Accedi qui</a>
        </div>
    </div>
</div>


</body>
</html>
