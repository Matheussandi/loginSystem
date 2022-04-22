<?php
require('config/connection.php');



if(isset($_GET['cod_confirm']) && !empty($_GET['cod_confirm'])){
    // Limpar o get
    $cod = cleanPost($_GET['cod_confirm']);


    // Verifica se existe algum usuário com o código de confirmação
    $sql = $pdo->prepare("SELECT * FROM login WHERE cod_confirm=? LIMIT 1");
    echo "<h1>DEBUG 1</h1>";
    $sql->execute(array($cod));
    echo "<h1>DEBUG 2</h1>";
    $user = $sql->fetch(PDO::FETCH_ASSOC);
    echo "<h1>DEBUG 3</h1>";
    
    if ($user) {
        // Atualiza status para confirmado
        $status = "confirmed";
        $sql = $pdo->prepare("UPDATE login SET status=? WHERE cod_confirm=?");
        if ($sql->execute(array($status, $cod))) {
            header('location: index.php?result=success');
        }
    } else {
        echo "<h1>Código de confirmação inválido !</h1>";
    }
}
