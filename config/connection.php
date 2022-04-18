<?php

    $mode = 'local';

    if ($mode == 'local') {
        define('HOST', '127.0.0.1:3307');
        define('DATABASE', 'loginsystem');
        define('USER', 'root');
        define('PASSWORD', '');
    }

    if ($mode == 'production') {
        define('HOST', '');
        define('DATABASE', '');
        define('USER', '');
        define('PASSWORD', '');
    }

    try {
        $pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // echo "Banco conectado com sucesso !!!";
    } catch (PDOException $e) {
        die('ERROR: '.$e->getMessage());
        // echo "Falha ao se conectar com o banco !!!";
    }

    function cleanPost($dice) {
        $dice = trim($dice);
        $dice = stripslashes($dice);
        $dice = htmlspecialchars($dice);
        return $dice;
    }