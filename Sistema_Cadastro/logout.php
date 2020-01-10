<?php 
    session_start();
    // ====Destruir a sessão====
    session_destroy();
    // ====Destruir os Cookies====
    unset($_COOKIE['user']);
    setcookie('user','');
    // ====Redirecionar para a tela de Login====
    header('Location: login.php');
