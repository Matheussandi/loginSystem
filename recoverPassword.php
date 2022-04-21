<?php
require('config/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'config/PHPMailer/src/Exception.php';
require 'config/PHPMailer/src/PHPMailer.php';
require 'config/PHPMailer/src/SMTP.php';

if (isset($_GET['cod']) && !empty($_GET['cod'])) {
    // Limpa get
    $cod = cleanPost($_GET['cod']);

    if (isset($_POST['password']) && isset($_POST['repeatPassword'])) {
        if (empty($_POST['password']) or empty($_POST['repeatPassword'])) {
            $generalError = "Todos os campos são obrigatórios !!!";
        } else {
            $password = cleanPost($_POST['password']);
            $passwordCript = sha1($password);
            $repeatPassword = cleanPost($_POST['repeatPassword']);

            if (strlen($password) < 6) {
                $errorPassword = "Senha deve ter no mínimo 6 caracteres !";
            }

            if ($password !== $repeatPassword) {
                $errorRepeatPassword = "Senha diferente da anterior !";
            }

            if (!isset($generalError) && !isset($errorPassword) && !isset($errorRepeatPassword)) {
                // Verifica a existência da recuperação de senha
                $sql = $pdo->prepare("SELECT * FROM login WHERE recoverPassword=? LIMIT 1");
                $sql->execute(array($codi));
                $user = $sql->fetch();
                if (!$user) {
                    echo "Recuperação de senha inválida";
                } else {
                    // Caso já exista usuário com este código de recuperação 
                    $sql = $pdo->prepare("UPDATE login SET password=? WHERE recoverPassword=?");
                    if ($sql->execute(array($passwordCript, $cod))) {
                        header('location: index.php');
                    }
                }
            }
        };
    }
} else {
    header('location: index.php');
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <title>Cadastrar</title>
</head>

<body class="gradient">
    <form method="post">
        <h1>Modificar senha</h1>

        <?php
        if (isset($generalError)) { ?>
            <div class='general-error animate__animated animate__headShake'>
                <?php echo $generalError; ?>
            </div>
        <?php } ?>


        <div class="input-group">
            <img class="input-icon" src="images/password.png">
            <input <?php if (isset($generalError) or isset($errorPassword)) {
                        echo 'class="error-input"';
                    } ?> type="password" name="password" 
                    
                    <?php if (isset($_POST['password'])) {
                        echo "value='" . $_POST['password'] . "'";
                    } ?> placeholder="Senha com no mínimo 6 dígitos" required>

            <?php if (isset($errorPassword)) { ?>
                <div class="error"><?php echo $errorPassword; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png">
            <input <?php if (isset($generalError) or isset($errorRepeatPassword)) {
                        echo 'class="error-input"';
                    } ?> type="password" name="repeatPassword" 
                    
                    <?php if (isset($_POST['repeatPassword'])) {
                        echo "value='" . $_POST['repeatPassword'] . "'";
                    } ?> placeholder="Repetir senha" required>

            <?php if (isset($errorRepeatPassword)) { ?>
                <div class="error"><?php echo $errorRepeatPassword; ?></div>
            <?php } ?>
        </div>

        <button class="btn-blue" type="submit">Alterar</button>
    </form>
</body>

</html>