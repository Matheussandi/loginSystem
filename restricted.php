<?php

    require('config/connection.php');

    $userRestricted = auth($_SESSION['TOKEN']);
    if ($userRestricted) {
        echo "<h1> Seja bem-vindo <b style='color:#009eff'>".$userRestricted['name']."</b></h1>";
        echo "<a href='logout.php' style='background:#009eff; color:white; padding:15px; border-radius:5px; text-decoration:none;'>Sair</a>";
    } else {
        header('location: index.php');
    }

/*     // Verificar se tem autorização
    $sql = $pdo->prepare("SELECT * FROM login WHERE token=? LIMIT 1");
    $sql->execute(array($_SESSION['TOKEN']));
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
        header('location: index.php');
    } else {
        echo "<h1> Seja bem-vindo <b style='color:#009eff'>".$user['name']."</b></h1>";
        echo "<a href='logout.php' style='background:#009eff; color:white; padding:15px; border-radius:5px; text-decoration:none;'>Sair</a>";
    } */