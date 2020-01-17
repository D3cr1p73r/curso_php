<?php


  header("Expires: 0");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
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
    <meta name="author" content="Giulianno Ferrari Iervolino">
    <meta charset="windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicita��o de Cadastro</title>
    <link rel="stylesheet" href="recursos/css/style.css">  
    <link rel="icon" type="imagem/png" href="recursos/icons/favicon.png" />  
    
</head>
<body>
    <?php 
        require_once("telas/template/header.php"); 
    ?>
    <main class="principal">
    <div class="row">
        <?php require_once("telas/template/menu.php");
        ?>
        <div class="principal col-10">
         <div class="conteudo col-12">
            <?php    
                
                if (isset($_GET['file']) == 1) {
                    include("{$_GET['file']}");
                }else{
                    include("telas/pendencias.php");
                }                
            ?>
        </div> 
    </div>
    </div>
    </main>
    <!-- teste -->
    <?php require_once("telas/template/footer.php"); ?>    
</body>
</html>