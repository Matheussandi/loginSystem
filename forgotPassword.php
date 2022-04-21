<?php
require('config/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'config/PHPMailer/src/Exception.php';
require 'config/PHPMailer/src/PHPMailer.php';
require 'config/PHPMailer/src/SMTP.php';

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = cleanPost($_POST['email']);
    $status = "confirmed";

    $sql = $pdo->prepare("SELECT * FROM login WHERE email=? AND status=? LIMIT 1");
    $sql->execute(array($email, $status));
    $user = $sql->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Envia para o usuário cria uma nova senha
        $mail = new PHPMailer(true);
        $cod = sha1(uniqid());

        // Atualiza o código de recuperação do usuário no banco
        $sql = $pdo->prepare("UPDATE login SET recoverPassword=? WHERE email=?");
        if ($sql->execute(array($cod, $email))) {
            try {
                // Recipients
                $mail->setFrom('sistema@email.com', 'Sistema de Login'); // mandante (Sistema)
                $mail->addAddress($email, $name); // receptor

                // Content - Corpo do e-mail como HTML
                $mail->isHTML(true);          //Set email format to HTML
                $mail->Subject = 'Recupere sua senha';
                $mail->Body    = '<h1>Recupere a senha:</h1><br><a style="background:#009eff; color:white; text-decoration:none; padding:20px; border-radius:5px;" href=https://systemlogin-matheussandi.tech/login/confirmation.php?cod_confirm=' . $cod . '">Recuperar</a><br><br><br><p>Equipe de Suporte</p>';

                $mail->send();
                header('location: thanksPassword.php');
            } catch (Exception $e) {
                echo "Houve um problema ao enviar o e-mail de confirmação {$mail->ErrorInfo}";
            }
        }
    } else {
        $errorUser = "Usuário não encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Esqueceu a senha</title>
</head>

<body class="gradient">
    <form method="post">
        <h1>Recuperar senha</h1>

        <?php
        if (isset($errorUser)) { ?>
            <div style="text-align:center" class='general-error animate__animated animate__headShake'>
                <?php echo $errorUser; ?>
            </div>
        <?php } ?>

        <p>Informe o e-mail cadastrado</p>

        <br><br>
        <div class="input-group">
            <img class="input-icon" src="images/user.png" alt="">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <button class="btn-blue" type="submit">Recuperar senha</button>

        <a href="index.php">Voltar</a>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>