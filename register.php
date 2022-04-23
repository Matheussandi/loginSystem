<?php
require('config/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'config/PHPMailer/src/Exception.php';
require 'config/PHPMailer/src/PHPMailer.php';
require 'config/PHPMailer/src/SMTP.php';

if (isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeatPassword'])) {
    if (empty($_POST['fullName']) or empty($_POST['email']) or empty($_POST['password']) or empty($_POST['repeatPassword']) or empty($_POST['terms'])) {
        $generalError = "Todos os campos são obrigatórios !!!";
    } else {
        $name = cleanPost($_POST['fullName']);
        $email = cleanPost($_POST['email']);
        $password = cleanPost($_POST['password']);
        $passwordCript = sha1($password);
        $repeatPassword = cleanPost($_POST['repeatPassword']);
        $checkbox = cleanPost($_POST['terms']);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $errorName = "Somente permitido letras e espaços em branco !";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorEmail = "E-mail inválido !";
        }

        if (strlen($password) < 6) {
            $errorPassword = "Senha deve ter no mínimo 6 caracteres !";
        }

        if ($password !== $repeatPassword) {
            $errorRepeatPassword = "Senha diferente da anterior !";
        }

        if ($checkbox !== "ok") {
            $errorCheckbox = "Desativado";
        }

        if (!isset($generalError) && !isset($errorName) && !isset($errorEmail) && !isset($errorPassword) && !isset($errorRepeatPassword) && !isset($errorCheckbox)) {
            // Verifica a existência do email no banco
            $sql = $pdo->prepare("SELECT * FROM login WHERE email=? LIMIT 1");
            $sql->execute(array($email));
            $user = $sql->fetch();
            if (!$user) {
                $recoverPassword = "";
                $token = "";
                $cod_confirm = uniqid();
                $site = 'http://systemlogin-matheussandi.tech/';
                $status = "new";
                $registrationDate = date('d/m/Y');

                $sql = $pdo->prepare("INSERT INTO login VALUES (null,?,?,?,?,?,?,?,?)");
                if ($sql->execute(array($name, $email, $passwordCript, $recoverPassword, $token, $cod_confirm, $status, $registrationDate))) {
                    if ($mode == "local") {
                        header('location: index.php?result=success');
                    }

                    if ($mode == "production") {
                        $mail = new PHPMailer(true);
                        try {
                            // Recipients
                            $mail->setFrom('sistema@email.com', 'Sistema de Login'); // mandante (Sistema)
                            $mail->addAddress($email, $name); // receptor

                            // Content - Corpo do e-mail como HTML
                            $mail->isHTML(true);          //Set email format to HTML
                            $mail->Subject = 'Confirme seu cadastro';
                            $mail->Body    = '<h1>Por favor confirme seu e-mail abaixo:</h1><br><a style="background:#009eff; color:white; text-decoration:none; padding:20px; border-radius:5px;" href="' .$site. 'confirmation.php?cod_confirm=' . $cod_confirm . '">Confirmar</a><br><br><p>Equipe de Login</p>';

                            $mail->send();
                            header('location: thanks.php');
                        } catch (Exception $e) {
                            echo "Houve um problema ao enviar o e-mail de confirmação {$mail->ErrorInfo}";
                        }
                    }
                }
            } else {
                $generalError = "Usuário existente";
            }
        }
    };
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
        <h1>Registrar</h1>

        <?php
        if (isset($generalError)) { ?>
            <div class='general-error animate__animated animate__headShake'>
                <?php echo $generalError; ?>
            </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="images/user.png">
            <input <?php if (isset($generalError) or isset($errorName)) {
                        echo 'class="error-input"';
                    } ?> type="text" name="fullName" <?php if (isset($_POST['fullName'])) {
                                                            echo "value='" . $_POST['fullName'] . "'";
                                                        } ?> placeholder="Nome Completo" required>
            <?php if (isset($errorName)) { ?>
                <div class="error"><?php echo $errorName; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/email.png">
            <input <?php if (isset($generalError) or isset($errorEmail)) {
                        echo 'class="error-input"';
                    } ?> type="email" name="email" <?php if (isset($_POST['email'])) {
                                                        echo "value='" . $_POST['email'] . "'";
                                                    } ?> placeholder="Email" required>
            <?php if (isset($errorEmail)) { ?>
                <div class="error"><?php echo $errorEmail; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png">
            <input <?php if (isset($generalError) or isset($errorPassword)) {
                        echo 'class="error-input"';
                    } ?> type="password" name="password" <?php if (isset($_POST['password'])) {
                                                                echo "value='" . $_POST['password'] . "'";
                                                            } ?> placeholder="Senha" required>
            <?php if (isset($errorPassword)) { ?>
                <div class="error"><?php echo $errorPassword; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png">
            <input <?php if (isset($generalError) or isset($errorRepeatPassword)) {
                        echo 'class="error-input"';
                    } ?> type="password" name="repeatPassword" <?php if (isset($_POST['repeatPassword'])) {
                                                                    echo "value='" . $_POST['repeatPassword'] . "'";
                                                                } ?> placeholder="Repetir senha" required>
            <?php if (isset($errorRepeatPassword)) { ?>
                <div class="error"><?php echo $errorRepeatPassword; ?></div>
            <?php } ?>
        </div>

        <div <?php if (isset($generalError) or isset($errorCheckbox)) {
                    echo 'class="input-group error-input labelTerms"';
                } else {
                    echo 'class="input-group labelTerms"';
                } ?>>
            <input type="checkbox" id="terms" name="terms" value="ok" required>
            <label for="terms">Ao se cadastrar você concorda com a nossa <a href="#" class="link">Política de Privacidade</a> e os <a href="#" class="link">Termos de uso.</a></label>
        </div>

        <button class="btn-blue" type="submit">Cadastrar</button>
        <a href="index.php"> Já tenho uma conta</a>
    </form>
</body>

</html>
