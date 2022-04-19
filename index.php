<?php
require('config/connection.php');

if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = cleanPost($_POST['email']);
    $password = cleanPost($_POST['password']);
    $passwordCript = sha1($password);

    $sql = $pdo->prepare("SELECT * FROM login WHERE email=? AND password=? LIMIT 1");
    $sql->execute(array($email, $passwordCript));
    $user = $sql->fetch(PDO::FETCH_ASSOC);
    if($user) {
        // verifica se o usuário confirmou o email
        if($user['status']=="confirmed") {
        // criação do token
            $token = sha1(uniqid().date('d-m-Y-H-i-s'));

            // Atualiza token do usuário no banco
            $sql = $pdo->prepare("UPDATE login SET token=? WHERE email=? AND password=?");
            if($sql->execute(array($token, $email, $passwordCript))) {
                // amarmazena token na sessão (SESSION)
                $_SESSION['TOKEN'] = $token;
                header('location: restricted.php');
            }
        } else {
            $errorLogin = "Por favor, confime seu e-mail !";
        }
    } else {
        $errorLogin = "Usuário e/ou senha incorretos";
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
    <title>Login</title>
</head>

<body>
    <form method="post">
        <h1>Login</h1>

        <?php if (isset($_GET['result']) && ($_GET['result'] == "success")) { ?>
            <div class="animate__animated animate__heartBeat success">
                Cadastrado com sucesso !!!
            </div>
        <?php } ?>

        <?php
            if(isset($errorLogin)) { ?>
                <div style="text-align:center" class='general-error animate__animated animate__headShake'>
                <?php echo $errorLogin; ?>
                </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="images/user.png" alt="">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png" alt="">
            <input type="password" name="password" placeholder="Senha" required>
        </div>


        <button class="btn-blue" type="submit">Entrar</button>
        <a href="register.php">Cadastrar</a>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
        <?php if (isset($_GET['result']) && ($_GET['result'] == "success")) { ?>
    </script>
    <script>
        setTimeout(() => {
            $('.success').hide();
        }, 3000)
    </script>

    <?php } ?>

</body>

</html>