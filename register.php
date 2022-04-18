<?php
    require('config/connection.php');

    if(isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeatPassword'])) {
        if(empty($_POST['fullName']) OR empty($_POST['email']) OR empty($_POST['password']) OR empty($_POST['repeatPassword']) OR empty($_POST['terms'])) {
            $generalError = "Todos os campos são obrigatórios !!!";
        } else {
            $name = cleanPost($_POST['fullName']);
            $email = cleanPost($_POST['email']);
            $password = cleanPost($_POST['password']);
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
        };
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" rel="stylesheet" >
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
    <title>Cadastrar</title>
</head>
<body>
    <form method="post">
        <h1>Registrar</h1>

        <?php
            if(isset($generalError)) { ?>
                <div class='general-error animate__animated animate__headShake'>
                <?php echo $generalError; ?>
                </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="images/user.png">
            <input <?php if(isset($generalError) or isset($errorName)){echo 'class="error-input"';}?> type="text" name="fullName" <?php if (isset($_POST['fullname'])){echo "value='".$_POST['fullname']."'";}?> placeholder="Nome Completo" required>
            <?php if(isset($errorName)){?>
            <div class="error"><?php echo $errorName; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/email.png">
            <input <?php if(isset($generalError) or isset($errorEmail)){echo 'class="error-input"';}?> type="email" name="email" <?php if (isset($_POST['email'])){echo "value='".$_POST['email']."'";}?> placeholder="Email" required>
            <?php if(isset($errorEmail)){?>
            <div class="error"><?php echo $errorEmail; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png">
            <input <?php if(isset($generalError) or isset($errorPassword)){echo 'class="error-input"';}?> type="password" name="password" <?php if (isset($_POST['password'])){echo "value='".$_POST['password']."'";}?> placeholder="Senha" required>
            <?php if(isset($errorPassword)){?>
            <div class="error"><?php echo $errorPassword; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png">
            <input <?php if(isset($generalError) or isset($errorRepeatPassword)){echo 'class="error-input"';}?> type="password" name="repeatPassword" <?php if (isset($_POST['repeatPassword'])){echo "value='".$_POST['repeatPassword']."'";}?> placeholder="Repetir senha" required>
            <?php if(isset($errorRepeatPassword)){?>
            <div class="error"><?php echo $errorRepeatPassword; ?></div>
            <?php } ?>
        </div>

        <div <?php if(isset($generalError) or isset($errorCheckbox)){echo 'class="input-group error-input labelTerms"';}else{echo 'class="input-group labelTerms"';}?>>
            <input type="checkbox" id="terms" name="terms" value="ok" required>
            <label for="terms">Ao se cadastrar você concorda com a nossa <a href="#" class="link">Política de Privacidade</a> e os <a href="#" class="link">Termos de uso.</a></label>
        </div>

        <button class="btn-blue" type="submit">Cadastrar</button>
        <a href="index.php"> Já tenho uma conta</a>
    </form>
</body>
</html>