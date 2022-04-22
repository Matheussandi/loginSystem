<?php

require('config/connection.php');

$userRestricted = auth($_SESSION['TOKEN']);

/*  // Verificar se tem autorização
    $sql = $pdo->prepare("SELECT * FROM login WHERE token=? LIMIT 1");
    $sql->execute(array($_SESSION['TOKEN']));
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
        header('location: index.php');
    } else {
        echo "<h1> Seja bem-vindo <b style='color:#009eff'>".$user['name']."</b></h1>";
        echo "<a href='logout.php' style='background:#009eff; color:white; padding:15px; border-radius:5px; text-decoration:none;'>Sair</a>";
    } */

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" rel="stylesheet">
    <title>Home</title>
</head>

<body class="gradient">
    <div class="text-center">
        <form>
            <?php
            if ($userRestricted) {
                echo "<h1> Seja bem-vindo <br> <b style='color:#009eff'>" . $userRestricted['name'] . "</b></h1>";
                echo '<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_puciaact.json" background="transparent" speed="1" style="width: 400px; height: 300px;" loop autoplay></lottie-player>';
                echo "<h1>  </h1>";
                echo "<a class='high' href='logout.php' style='background:#009eff; color:white; padding:15px; border-radius:5px; text-decoration:none;'>Sair</a>";
            } else {
                header('location: index.php');
            }
            ?>
        </form>
    </div>
</body>

</html>