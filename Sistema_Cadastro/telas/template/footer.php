<?php
$user = $_SESSION['user'];

echo "<footer class='rodape'>
        <p>Usuário:".strtoupper($_SESSION['user'])."</p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <p class='btn'><a class='font_white' href='logout.php'>Sair</a></p>
    </footer>  ";  