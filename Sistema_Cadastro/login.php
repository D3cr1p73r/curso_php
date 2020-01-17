<?php 
require_once("recursos/functions/funcoes.php");
session_start();
// print_r($_POST);
if ($_POST['user'] and $_POST['password']){
    $login['user'] = strtoupper($_POST['user']);
    $login['password'] = strtoupper(md5($_POST['password']));
    $logon = checaLogin($login);
    if ($logon['chk_login'] == 1){
        echo "Logon bem sucedido";
        $_SESSION['user'] = $login['user'];
        $exp = time() + 60 * 60 * 24 * 30;
        // Criar cookie para usuário:
        setcookie('user', $login['user'],$exp);
        unset($_POST);
        header('Location: index.php');
    }else{
        // echo "Logon mal sucedido";
        // print_r($logon);
        // echo "<br>";
        // print_r($login);
        $error = 'Usuário ou senha inválidos';
        unset($_POST);
    }
}
// session_destroy();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="author" content="Giulianno Ferrari Iervolino">
    <meta name="description" content="Tela de Login">
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="recursos/css/login.css">
</head>

    <body>
        <?php echo $_POST['user']; ?>
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
                            Não é Cadastrado? <a href="telas/usuario/cadastro.php">Crie uma Conta</a>
                        </div>
                        <?php if ($error != null):?>
                            <!-- <div class='message'> -->
                            <span style="color: red;">
                                <?php if ($error != null){ echo $error;} ?>
                            <!-- </div> -->
                            </span>
                        <?php endif ?>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>