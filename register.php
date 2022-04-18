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
    <form>
        <h1>Registrar</h1>

        <div class="general-error animate__animated animate__headShake">
            Aparece o erro para o usuário
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/user.png" alt="">
            <input class="error-input" type="text" placeholder="Nome Completo">
            <div class="error">Informe um nome válido</div>
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/email.png" alt="">
            <input type="email" placeholder="Email">
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png" alt="">
            <input type="password" placeholder="Senha">
        </div>

        <div class="input-group">
            <img class="input-icon" src="images/password.png" alt="">
            <input type="password" placeholder="Repetir senha">
        </div>

        <div class="input-group">
            <input type="checkbox" id="terms" name="terms" value="ok">
            <label for="terms">Ao se cadastrar você concorda com a nossa <a href="#" class="link">Política de Privacidade</a> e os <a href="#" class="link">Termos de uso.</a></label>
        </div>

        <button class="btn-blue" type="submit">Cadastrar</button>
        <a href="index.php"> Já tenho uma conta</a>
    </form>
</body>
</html>