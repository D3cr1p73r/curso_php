<?php
    session_start();

    // Verificar se o cookie existe e utiliza-lo em caso positivo
    if($_COOKIE['user']){
        $_SESSION['user'] = $_COOKIE['user'];
    }

    if(!$_SESSION['user']){
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head class >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitação de Cadastro</title>
    <link rel="stylesheet" href="recursos/css/style.css">  
    <link rel="icon" type="imagem/png" href="recursos/icons/favicon.png" />  
</head>
<body>
    <?php require_once("telas/template/header.php"); ?>
    <div class="row">
        <?php require_once("telas/template/menu.php"); ?>
        <main class="principal col-10">
         <div class="conteudo col-12">
            <?php    
                if (isset($_GET['file']) == 1) {
                    include(__DIR__ . "/{$_GET['file']}");
                }else{
                    echo "Selecione uma opção no menu lateral.";
                }                
            ?>
        </div> 
    </main>
    </div>
    
    <?php require_once("telas/template/footer.php"); ?>    
</body>
</html>