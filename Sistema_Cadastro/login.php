<?php 
session_start();
error_reporting(0);
ini_set("display_errors", 0 );

$user       = $_POST['user'];
$password   = $_POST['password'];
if ($_POST['user']){
    $users = [
        [
            "user" => "giervolino",
            "password" => "senha123#",
        ],
        [
            "user" => "teste",
            "password" => "teste",
        ],
    ];

    foreach($users as $login){
        $validUser =  $user === $login['user'];
        $validPassw = $password === $login['password'];

        if($validUser && $validPassw){
            $_SESSION['user'] = $login['user'];
            $_SESSION['errors'] = null;
            $exp = time() + 60 * 60 * 24 * 30;
            // Criar cookie para usuário:
            setcookie('user', $_SESSION['user'],$exp);
            header('Location: index.php#');
        }
    }
    if(!$_SESSION['user']){
        $_SESSION['errors'] = 'Usuário ou senha iválida';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- <meta name="author" content="Diego Ferreira"> -->
    <meta name="description" content="Tela de Login">
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="recursos/css/login.css">
</head>
    <body>
        <div class="container">
            <div class = 'box'>
                <div class="form-box">
                    <form action="#" method="post">
                        <div>
                            <h1>Login</h1>
                        </div>
                        <div>
                            <input type="text" name="user" id="user" placeholder="Informe seu Login" class="form-input">
                        </div>
                        <div>
                            <input type="password" name="password" id="password" placeholder="Informe sua Senha" class="form-input">
                        </div>
                        <div>
                            <input type="submit" value="Entrar" class="form-btn">
                        </div>
                        <div>
                            Não é Cadastrado? <a href="telas/usuario/cadastro.html">Crie uma Conta</a>
                        </div>
                        <?php if ($_SESSION['errors']): ?>
                            <div>
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <p><?= $error ?></p>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>