
<?php
require_once('config.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body>


<div class="relative flex flex-col items-center justify-center h-screen overflow-hidden">
    <h1 class="text-3xl font-semibold text-center text-gray-700 mb-4">Bed and Breakfast</h1>
    <div class="w-full p-6 bg-white border-t-4 border-gray-600 rounded-md shadow-md border-top lg:max-w-lg">
    <?php
        // Verifica se è presente un messaggio di errore o di successo nell'URL
        if (isset($_GET['error'])) {
            echo '<div id="alertMessage" class="alert alert-error w-full">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            echo '<span>' . $_GET['error'] . '</span>';
            echo '</div>';
        }
        ?>
        <h1 class="text-3xl font-semibold text-center text-gray-700">Accedi</h1>
        <form class="space-y-4" action="login_process.php" method="POST">
            <div>
                <label class="label">
                    <span class="text-base label-text">Email</span>
                </label>
                <input type="email" name="email" placeholder="Email Address" class="w-full input input-bordered" required />
            </div>
            <div>
                <label class="label">
                    <span class="text-base label-text">Password</span>
                </label>
                <input type="password" name="password" placeholder="Enter Password" class="w-full input input-bordered" required />
            </div>
            
            <div>
                <button type="submit" class="btn btn-block">Login</button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <span>Non hai un account?</span>
            <a href="register.php" class="text-indigo-600 font-bold">Registrati qui</a>
        </div>
    </div>
</div>
<script>
    // Nasconde l'alert dopo 5 secondi
    setTimeout(() => {
        document.getElementById('alertMessage').style.display = 'none';
    }, 4000);
</script>
</body>
</html>