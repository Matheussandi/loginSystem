<?php
session_start();

// Biblioteca para disparo de email

$mode = 'local';

if ($mode == 'local') {
    define('HOST', 'localhost');
    define('DATABASE', '');
    define('USER', '');
    define('PASSWORD', '');
}

if ($mode == 'production') {
    define('HOST', '');
    define('DATABASE', '');
    define('USER', '');
    define('PASSWORD', '');
}

try {
    $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Banco conectado com sucesso !!!";
} catch (PDOException $e) {
    die('ERROR: ' . $e->getMessage());
    // echo "Falha ao se conectar com o banco !!!";
}

function cleanPost($dice) {
    $dice = trim($dice);
    $dice = stripslashes($dice);
    $dice = htmlspecialchars($dice);
    return $dice;
}

function auth($tokenSession) {
    global $pdo;
    // Verificar se tem autorização
    $sql = $pdo->prepare("SELECT * FROM login WHERE token=? LIMIT 1");
    $sql->execute(array($tokenSession));
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    } else {
        return $user;
    }
}
