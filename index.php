<?php
require('config/connection.php');
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
    <form>
        <h1>Login</h1>

        <?php if (isset($_GET['result']) && ($_GET['result'] == "success")) { ?>
            <div class="animate__animated animate__heartBeat success">
                Cadastrado com sucesso !!!
            </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="images/user.png" alt="">
            <input type="email" placeholder="Email">
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png" alt="">
            <input type="password" placeholder="Senha">
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