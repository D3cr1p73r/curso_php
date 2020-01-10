<?php
$user = $_SESSION['user'];

echo"<link rel='stylesheet' href='../../recursos/css/style.css'>";
echo "<footer class='rodape'>
        <p>Usuário: $user</p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <p class='btn'><a class='font_white' href='logout.php'>Sair</a></p>
    </footer>  ";  